<?php
/**
 * Created by PhpStorm.
 * User: maps_red
 * Date: 10/11/16
 * Time: 16:12
 */

namespace AppBundle\Form;

use AppBundle\Entity\Order;
use Symfony\Bundle\FrameworkBundle\Routing\Router;
use Symfony\Component\Form\AbstractType;
use Symfony\Component\Form\FormBuilderInterface;
use Symfony\Component\OptionsResolver\OptionsResolver;

class PaiementForm extends AbstractType
{
    /**
     * @param FormBuilderInterface $builder
     * @param array $options
     */
    public function buildForm(FormBuilderInterface $builder, array $options)
    {
        /** @var Order $order */
        $order = $options['order'];
        /** @var Router $router */
        $router = $options['router'];

        $builder->create(
            'jms_choose_payment_method',
            null,
            [
                'amount' => $order->getAmount(),
                'currency' => 'EUR',
                'default_method' => 'payment_paypal', // Optional
                'predefined_data' => [
                    'paypal_express_checkout' => [
                        'return_url' =>
                            $router->generate('payment_complete', ['orderNumber' => $order->getOrderNumber()], true),
                        'cancel_url' =>
                            $router->generate('payment_cancel', ['orderNumber' => $order->getOrderNumber()], true),
                    ],
                ],
            ]
        );
    }

    /**
     * @param OptionsResolver $resolver
     */
    public function configureOptions(OptionsResolver $resolver)
    {
        $resolver->setDefaults(['order' => Order::class, "router" => null]);
    }
}