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
use Symfony\Component\Form\Extension\Core\Type\EmailType;
use Symfony\Component\Form\Extension\Core\Type\PasswordType;
use Symfony\Component\Form\Extension\Core\Type\RepeatedType;
use Symfony\Component\Form\Extension\Core\Type\TextType;
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
        $fields = ['email' => EmailType::class, 'username' => TextType::class, "plainPassword" => null];
        $placeholders = ['email' => "Email", "username" => "Pseudo", "plainPassword" => "Mot de passe"];
        $params = ['attr' => ['class' => "login_form_control"], "label_attr" => ['class' => "hidden"], 'translation_domain' => 'FOSUserBundle'];
        foreach ($fields as $field => $type) {
            $params['attr']['placeholder'] = $placeholders[$field];
            if ($field == "plainPassword") {
                $builder->add('plainPassword', RepeatedType::class, $this->getPasswordOptions());
            } else {
                $builder->add($field, $type, $params);
            }
        }
    }

    /**
     * @return array
     */
    private function getPasswordOptions()
    {
        return [
            'type' => PasswordType::class,
            'options' => ['translation_domain' => 'FOSUserBundle', "label_attr" => ['class' => "hidden"]],
            'first_options' => ['attr' => ['placeholder' => 'Mot de passe', 'class' => "login_form_control"]],
            'second_options' => ['attr' => ['placeholder' => 'Confirmer le mot de passe', 'class' => "login_form_control"]],
            'invalid_message' => 'fos_user.password.mismatch',
        ];
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