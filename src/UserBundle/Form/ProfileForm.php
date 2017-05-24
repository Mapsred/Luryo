<?php

namespace UserBundle\Form;

use AppBundle\Form\AddressType;
use Symfony\Bridge\Doctrine\Form\Type\EntityType;
use Symfony\Component\Form\AbstractType;
use Symfony\Component\Form\Extension\Core\Type\ChoiceType;
use Symfony\Component\Form\Extension\Core\Type\EmailType;
use Symfony\Component\Form\Extension\Core\Type\TextType;
use Symfony\Component\Form\FormBuilderInterface;
use Symfony\Component\OptionsResolver\OptionsResolver;

class ProfileForm extends AbstractType
{
    public function buildForm(FormBuilderInterface $builder, array $options)
    {
        $birthday = $options['birthday'] instanceof \DateTime ? $options['birthday']->format("d/m/Y") : null;
        $builder
            ->add("sexe", ChoiceType::class, ['label' => "Sexe", "choices" => ["Homme" => "M", "Femme" => "F"]])
            ->add("interests", EntityType::class, ['class' => 'AppBundle\Entity\Interest', 'multiple' => true])
            ->add("email", EmailType::class, ['attr' => ['placeholder' => "Email"]])
            ->add("address", AddressType::class, ['label_attr' => ['class' => "hidden"]])
            ->add("birthday", TextType::class, ['mapped' => false, 'attr' => ['placeholder' => "Date de naissance", "value" => $birthday]])
            ->add("firstname", TextType::class, ["attr" => ['placeholder' => "Prénom"]])
            ->add("lastname", TextType::class, ["attr" => ['placeholder' => "Nom"]]);
    }

    /**
     * @param OptionsResolver $resolver
     */
    public function configureOptions(OptionsResolver $resolver)
    {
        $resolver->setDefaults(['data_class' => 'UserBundle\Entity\User', 'birthday' => null]);
    }

    public function getName()
    {
        return 'user_bundle_profile_form';
    }


}
