<?php
/**
 * Created by PhpStorm.
 * User: maps_red
 * Date: 10/11/16
 * Time: 15:58
 */

namespace AppBundle\Controller;

use AppBundle\Entity\PaypalOrder;
use AppBundle\Entity\Travel;
use Sensio\Bundle\FrameworkExtraBundle\Configuration\Route;
use Symfony\Bundle\FrameworkBundle\Controller\Controller;
use Symfony\Component\HttpFoundation\RedirectResponse;
use Symfony\Component\HttpFoundation\Request;


/**
 * @Route("/payments")
 */
class PaymentController extends Controller
{
    /**
     * @Route("/{id}/details", name="paypal_details")
     * @param Travel $travel
     * @return \Symfony\Component\HttpFoundation\RedirectResponse
     */
    public function detailsAction(Travel $travel)
    {
        // Ici Song représente la chanson à acheter
        // Initialisation d'un objet Order et flush afin d'avoir l'id de dispo pour l'url de retour (RETURNURL)
        $em = $this->getDoctrine()->getManager();
        $order = new PaypalOrder($travel->getPrice());
        $order->setTravel($travel);
        $em->persist($order);
        $em->flush();

        $data = [
            'METHOD' => 'SetExpressCheckout',
            'CANCELURL' => $this->get('router')->generate('homepage', [], true),
            'RETURNURL' => $this->get('router')->generate('paypal_complete', ['id' => $order->getId()], true),
            'PAYMENTREQUEST_0_AMT' => $travel->getPrice(),
            'PAYMENTREQUEST_0_ITEMAMT' => $travel->getPrice(),
            'PAYMENTREQUEST_0_PAYMENTACTION' => 'Sale',
            'PAYMENTREQUEST_0_CURRENCYCODE' => 'EUR',
            'L_PAYMENTREQUEST_0_NAME0' => $travel->getTitle(),
            'L_PAYMENTREQUEST_0_QTY0' => '1',
            'L_PAYMENTREQUEST_0_AMT0' => $travel->getPrice(),
            'SOLUTIONTYPE' => 'Sole',
            'LANDINGPAGE' => 'Billing',
            'CURRENCYCODE' => 'EUR',
            'DESC' => $travel->getTitle(),
            'LOCALECODE' => 'FR',
            //'HDRIMG' => 'http://www.siteduzero.com/Templates/images/designs/2/logo_sdz_fr.png',
        ];
        //La fonction sendPaypal est une fonction privé de la classe expliquée plus bas
        $return_paypal = $this->sendPaypal($data);
        //La fonction getPaypalParam découpe et transforme la chaine de caractère retourné par Paypal en un tableau associatif
        $param = $this->getPaypalParam($return_paypal);
        //Pour ma part je stock le tout le retour en json dans l'entité mais libre à vous de faire votre propre logique ! la mienne est très bourrine par manque de temps
        $order->setPaypalParams(json_encode($param));
        $em->flush();
        //Si le premier retour de paypal est OK, on redirige vers paypal pour que le client puisse effectuer le paiement
        if ($param['ACK'] == 'Success') {
            return $this->redirect(
                "https://www.sandbox.paypal.com/webscr&cmd=_express-checkout&token=".$param['TOKEN']
            );
        }
    }

    /**
     * @Route("/{id}/complete", name="paypal_complete")
     * @param PaypalOrder $order
     * @param Request $request
     * @return RedirectResponse
     */
    public function completeAction(PaypalOrder $order, Request $request)
    {
        //si on a pas de token ou de payerId, on a rien a faire la
        if (!$request->get('token') || !$request->get('PayerID')) {
            throw $this->createNotFoundException();
        }
        //si l'objet $order est déjà renseigné, on a rien a faire la non plus
        if ($order->getPaypalDetails() != null || $order->getPaypalComplete() != null) {
            throw $this->createNotFoundException();
        }

        $em = $this->getDoctrine()->getManager();

        //Récupération des infos sur l'user et on stoke ça dans l'objet PaypalOrder
        $data = [
            'METHOD' => 'GetExpressCheckoutDetails',
            'TOKEN' => urldecode($request->get('token')),
        ];

        $orderDetails = $this->getPaypalParam($this->sendPaypal($data));

        $order->setEmail($orderDetails['EMAIL']);
        $order->setName($orderDetails['PAYMENTREQUEST_0_SHIPTONAME']);
        $order->setAddress(
            $orderDetails['PAYMENTREQUEST_0_SHIPTOSTREET']." / ".
            $orderDetails['PAYMENTREQUEST_0_SHIPTOCITY']." / ".
            $orderDetails['PAYMENTREQUEST_0_SHIPTOCOUNTRYNAME']
        );
        $order->setDate(new \DateTime());
        $order->setPaypalDetails(json_encode($orderDetails));
        $em->flush();

        //Envoi de la requete de paiement et récupération du résultat final dans l'objet PaypalOrder
        $data = [
            'PAYMENTREQUEST_0_PAYMENTACTION' => 'Sale',
            'PAYERID' => urldecode($request->get('PayerID')),
            'TOKEN' => urldecode($request->get('token')),
            'PAYMENTREQUEST_0_AMT' => $order->getAmount(),
            'PAYMENTREQUEST_0_CURRENCYCODE' => 'EUR',
            'METHOD' => 'DoExpressCheckoutPayment',
        ];

        $orderComplete = $this->getPaypalParam($this->sendPaypal($data));
        //Utilisation de la fonction privé qui laisse 5 téléchargement à mon utilisateur
        if ($orderComplete['PAYMENTINFO_0_PAYMENTSTATUS'] == "Completed") {
            //completed
        }
        //Mise à jour de l'objet Order (modification impossible par la suite)
        $order->setStatut($orderComplete['PAYMENTINFO_0_PAYMENTSTATUS']);
        $order->setPaypalComplete(json_encode($orderComplete));
        $em->flush();

        return $this->redirectToRoute("homepage");
    }

    private function sendPaypal($data)
    {
        //Récupération des paramètre que j'ai stoqué dans parameter.yml
        $api_paypal = $this->container->getParameter('paypal_api_url');
        $version = $this->container->getParameter('paypal_api_version');
        $user = $this->container->getParameter('paypal_username');
        $pass = $this->container->getParameter('paypal_password');
        $signature = $this->container->getParameter('paypal_signature');
        //construction de l'url
        $url = sprintf("%s?VERSION=%s&USER=%s&PWD=%s&SIGNATURE=%s", $api_paypal, $version, $user, $pass, $signature);
        //ajout des paramètres passé en paramètres (cette phrase est très philosophique...)
        foreach ($data as $key => $value) {
            $url .= '&'.$key."=".urlencode($value);
        }
        $ch = curl_init($url);
        curl_setopt($ch, CURLOPT_SSL_VERIFYPEER, 0);
        curl_setopt($ch, CURLOPT_RETURNTRANSFER, 1);
        $res = curl_exec($ch);
        curl_close($ch);
        if (!$res) {
            echo "<p>Erreur</p><p>".curl_error($ch)."</p>";
            exit;
        }

        //on retourne le resultat
        return $res;
    }

    private function getPaypalParam($url)
    {
        $params = [];
        $lst_params = explode('&', $url);
        foreach ($lst_params as $param_paypal) {
            list($nom, $valeur) = explode("=", $param_paypal);
            $params[$nom] = urldecode($valeur);
        }

        return $params;
    }
}

