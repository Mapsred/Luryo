<?php
/**
 * Created by PhpStorm.
 * User: Maps_red
 * Date: 2016-11-14
 * Time: 13:55
 */

namespace AppBundle\Controller;

require __DIR__.'/../../../vendor/paypal/rest-api-sdk-php/sample/common.php';

use AppBundle\Entity\Order;
use AppBundle\Entity\Travel;
use PayPal\Api\Amount;
use PayPal\Api\Details;
use PayPal\Api\Item;
use PayPal\Api\ItemList;
use PayPal\Api\Payer;
use PayPal\Api\Payment;
use PayPal\Api\PaymentExecution;
use PayPal\Api\RedirectUrls;
use PayPal\Api\Transaction;
use ResultPrinter;
use Sensio\Bundle\FrameworkExtraBundle\Configuration\Route;
use Symfony\Bundle\FrameworkBundle\Controller\Controller;
use Symfony\Component\Config\Definition\Exception\Exception;
use Symfony\Component\HttpFoundation\JsonResponse;
use Symfony\Component\HttpFoundation\Request;

class PaymentController extends Controller
{
    /**
     * @Route("/payment", name="payment")
     */
    public function operationAction()
    {
        $payer = new Payer();
        $payer->setPaymentMethod("paypal");

        $travel = $this->getDoctrine()->getManager()->getRepository("AppBundle:Travel")->findOneBy(['id' => 2]);
        $item = $this->TravelToItem($travel);

        $itemList = new ItemList();
        $itemList->setItems([$item]);

        $details = new Details();
        $details->setSubtotal(doubleval($item->getPrice()));

        $amount = new Amount();
        $amount->setCurrency($item->getCurrency())->setTotal($details->getSubtotal());

        $transaction = new Transaction();
        $transaction->setAmount($amount)->setItemList($itemList)->setDescription("Payment description")
            ->setInvoiceNumber(uniqid());

        $baseUrl = getBaseUrl()."/payment/completing?success";
        $redirectUrls = new RedirectUrls();
        $redirectUrls->setReturnUrl("$baseUrl=true")->setCancelUrl("$baseUrl=false");

        $payment = new Payment();
        $payment->setIntent("sale")->setPayer($payer)->setRedirectUrls($redirectUrls)->setTransactions([$transaction]);

        #May launch an Exception on failure
        $payment->create($this->get("paypal")->getApiContext());

        $approvalUrl = $payment->getApprovalLink();

        return $this->redirect($approvalUrl);
    }

    /**
     * @param Travel $travel
     * @return Item
     */
    private function TravelToItem(Travel $travel)
    {
        $item = new Item();

        return $item
            ->setName($travel->getTitle())
            ->setCurrency('EUR')
            ->setQuantity(1)
            ->setSku($travel->getId())// Similar to `item_number` in Classic API
            ->setPrice($travel->getPrice());
    }

    /**
     * @Route("/payment/completing", name="payment_completing")
     * @param Request $request
     * @return JsonResponse
     */
    public function paymentCompletingAction(Request $request)
    {
        if ($request->query->has("success") && $request->query->get("success") == 'true') {
            $paymentId = $request->query->get("paymentId");
            $payment = Payment::get($paymentId, $this->get("paypal")->getApiContext());
            $transaction = $payment->getTransactions()[0];
            $item = $transaction->getItemList()->getItems()[0];
            $travel = $this->getDoctrine()->getRepository("AppBundle:Travel")->findOneBy(['id' => $item->getSku()]);

            $order = $this->getDoctrine()->getRepository("AppBundle:Order")
                ->findOneBy(['user' => $this->getUser(), 'travel' => $travel]);
            $order->setUuid($paymentId)->setDone(true);

            $execution = new PaymentExecution();
            $execution->setPayerId($request->query->get("PayerID"));
            $execution->addTransaction($transaction);

            try {
                $result = $payment->execute($execution, $this->get("paypal")->getApiContext());
                ResultPrinter::printResult("Executed Payment", "Payment", $payment->getId(), $execution, $result);

                try {
                    $payment = Payment::get($paymentId, $this->get("paypal")->getApiContext());
                } catch (\Exception $ex) {
                    ResultPrinter::printError("Get Payment", "Payment", null, null, $ex);
                    exit(1);
                }
            } catch (\Exception $ex) {
                ResultPrinter::printError("Executed Payment", "Payment", null, null, $ex);
                exit(1);
            }

            ResultPrinter::printResult("Get Payment", "Payment", $payment->getId(), null, $payment);

            return new JsonResponse(['content' => $payment]);
        }else {
            ResultPrinter::printResult("User Cancelled the Approval", null);
            exit;
        }
    }
}