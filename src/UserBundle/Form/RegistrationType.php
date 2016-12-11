<?php
/**
 * Created by PhpStorm.
 * User: maps_red
 * Date: 25/10/16
 * Time: 15:49
 */
namespace UserBundle\Form;

use Symfony\Component\Form\AbstractType;
use Symfony\Component\Form\Extension\Core\Type\ChoiceType;
use Symfony\Component\Form\FormBuilderInterface;
use Symfony\Component\Form\Extension\Core\Type\DateType;

class RegistrationType extends AbstractType
{
    /**
     * @param FormBuilderInterface $builder
     * @param array $options
     */
    public function buildForm(FormBuilderInterface $builder, array $options)
    {
        $builder->add(
            'birthday',
            DateType::class,
            [
                'format' => \IntlDateFormatter::LONG,
                'years' => range(date('Y'), date('Y') - 90),
                'label' => "Date de naissance",
            ]
        )->add("sexe", ChoiceType::class, ['label' => "Sexe", "choices" => ["Homme" => "M", "Femme" => "F"]])
        ;

    }

    public function getParent()
    {
        return 'FOS\UserBundle\Form\Type\RegistrationFormType';
    }

    public function getBlockPrefix()
    {
        return 'app_user_registration';
    }

}