<?php
/**
 * Created by PhpStorm.
 * User: maps_red
 * Date: 29/11/16
 * Time: 11:09
 */

namespace AppBundle\Utils;

use AppBundle\Entity\Order;
use AppBundle\Entity\Travel;
use Doctrine\Common\Persistence\ObjectManager;
use PayPal\Api\Amount;
use PayPal\Api\Details;
use PayPal\Api\Item;
use PayPal\Api\ItemList;
use PayPal\Api\Payer;
use PayPal\Api\Payment;
use PayPal\Api\PaymentExecution;
use PayPal\Api\RedirectUrls;
use PayPal\Api\Transaction;
use PayPal\Rest\ApiContext;
use Symfony\Component\DependencyInjection\ContainerInterface;
use Symfony\Component\HttpFoundation\Request;
use Symfony\Component\Routing\Generator\UrlGeneratorInterface;
use Symfony\Component\Security\Core\Authentication\Token\Storage\TokenStorage;
use UserBundle\Entity\User;

/**
 * Class Paypal
 * @package AppBundle\Utils
 */
class Paypal
{
    /** @var User $user */
    private $user;
    /** @var ObjectManager $em */
    private $em;
    /** @var ContainerInterface $container */
    private $container;

    /**
     * @param ContainerInterface $container
     */
    public function __construct(ContainerInterface $container)
    {
        $this->em = $container->get("doctrine")->getManager();
        $this->user = $container->get("security.token_storage")->getToken()->getUser();
        $this->container = $container;
    }

    /* ********** GETTERS ********** */

    /**
     * @return User
     */
    public function getUser()
    {
        return $this->user;
    }

    /**
     * @return ObjectManager
     */
    public function getManager()
    {
        return $this->em;
    }

    /* ********** UTILS ********** */

    /**
     * @param Travel $travel
     * @param string $status
     * @return string
     */
    public function generateCheckoutUrl(Travel $travel, $status)
    {
        return $this->container->get('router')->generate("checkout",
            ['slug' => $travel->getSlug(), "status" => $status], UrlGeneratorInterface::ABSOLUTE_URL
        );
    }

    /* ********** CORE ********** */
    /**
     * @param Travel $travel
     * @return null|string
     */
    public function generatePaiementURL(Travel $travel)
    {
        $urls = new RedirectUrls();
        $urls->setReturnUrl($this->generateCheckoutUrl($travel, "confirmed"))
            ->setCancelUrl($this->generateCheckoutUrl($travel, "failed"));

        return $this->payment($urls, $travel);
    }

    /**
     * @param RedirectUrls $urls
     * @param Travel $travel
     * @return null|string
     */
    public function payment(RedirectUrls $urls, Travel $travel)
    {
        $apiContext = $this->container->get("paypal")->getApiContext();
        $payer = new Payer();
        $payer->setPaymentMethod("paypal");

        $item = new Item();
        $sku = md5($this->getUser()->getEmail());
        $item
            ->setName($travel->getTitle())
            ->setDescription(sprintf("Paiement de la sortie %s", $travel->getTitle()))
            ->setQuantity(1)
            ->setPrice($travel->getPrice())
            ->setSku($sku)
            ->setCurrency("EUR");

        $itemList = new ItemList();
        $itemList->setItems([$item]);

        $details = new Details();
        $details->setSubtotal(doubleval($item->getPrice()));

        $amount = new Amount();
        $amount->setCurrency($item->getCurrency())->setTotal($details->getSubtotal());

        $transaction = new Transaction();
        $transaction->setAmount($amount)->setItemList($itemList)
            ->setDescription("Paiement")->setInvoiceNumber(uniqid());

        $payment = new Payment();
        $payment->setIntent("sale")->setPayer($payer)->setRedirectUrls($urls)->setTransactions([$transaction]);

        #May launch an Exception upon failure
        $payment->create($apiContext);

        return $payment->getApprovalLink();
    }

    /**
     * @param Request $request
     * @param Travel $travel
     * @return array
     */
    public function completing(Request $request, Travel $travel)
    {
        $apiContext = $this->container->get("paypal")->getApiContext();
        if ($request->query->has("status") && $request->query->get("status") == 'confirmed') {
            $paymentId = $request->query->get("paymentId");
            $payment = Payment::get($paymentId, $apiContext);
            $transaction = $payment->getTransactions()[0];

            $order = $this->getManager()->getRepository("AppBundle:Order")->findOneBy(['uuid' => $paymentId]);
            if ($order) {
                return ["danger", "Paiement déjà effectué"];
            }

            $order = new Order();
            $order->setUser($this->getUser())
                ->setAmount($transaction->getAmount()->getTotal())
                ->setTravel($travel)
                ->setUuid($paymentId)
                ->setDone(true);

            $execution = new PaymentExecution();
            $execution->setPayerId($request->query->get("PayerID"))->addTransaction($transaction);
            $this->getManager()->persist($order);
            $this->getManager()->flush();

            return ["success", "Paiement réussi"];
        }

        return ["warning", "Paiement annulé"];
    }
}