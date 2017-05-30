<?php

namespace UserBundle\Form;

use Symfony\Component\Form\AbstractType;
use Symfony\Component\Form\Extension\Core\Type\EmailType;
use Symfony\Component\Form\Extension\Core\Type\TextareaType;
use Symfony\Component\Form\Extension\Core\Type\TextType;
use Symfony\Component\Form\FormBuilderInterface;
use Symfony\Component\OptionsResolver\OptionsResolver;

class ContactType extends AbstractType
{
    /**
     * {@inheritdoc}
     */
    public function buildForm(FormBuilderInterface $builder, array $options)
    {
        $builder
            ->add('firstname', TextType::class, ['attr' => ["placeholder" => "Prénom"]])
            ->add('lastname', TextType::class, ['attr' => ["placeholder" => "Nom"]])
            ->add('phone', TextType::class, ['attr' => ["placeholder" => "N° de téléphone"], "required" => false])
            ->add('email', EmailType::class, ['attr' => ["placeholder" => "Adresse email"]])
            ->add('reason', TextType::class, ['attr' => ["placeholder" => "Motif"]])
            ->add('message', TextareaType::class, ['attr' => ["placeholder" => "Votre message"]]);
    }
    
    /**
     * {@inheritdoc}
     */
    public function configureOptions(OptionsResolver $resolver)
    {
        $resolver->setDefaults(['data_class' => 'UserBundle\Entity\Contact']);
    }

    /**
     * {@inheritdoc}
     */
    public function getBlockPrefix()
    {
        return 'userbundle_contact';
    }


}
