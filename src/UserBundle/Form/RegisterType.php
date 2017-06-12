<?php

namespace UserBundle\Form;

use Symfony\Component\Form\AbstractType;
use Symfony\Component\Form\Extension\Core\Type\EmailType;
use Symfony\Component\Form\Extension\Core\Type\IntegerType;
use Symfony\Component\Form\Extension\Core\Type\TextareaType;
use Symfony\Component\Form\Extension\Core\Type\TextType;
use Symfony\Component\Form\FormBuilderInterface;
use Symfony\Component\OptionsResolver\OptionsResolver;

class RegisterType extends AbstractType
{
    /**
     * {@inheritdoc}
     */
    public function buildForm(FormBuilderInterface $builder, array $options)
    {
        $builder
            ->add('fullname', TextType::class, ['attr' => ['placeholder' => "Nom Prénom"]])
            ->add('age', IntegerType::class, ['attr' => ['placeholder' => "Age"]])
            ->add('phone', TextType::class, ['attr' => ['placeholder' => "Numéro de téléphone"]])
            ->add('establishment', TextType::class, ['attr' => ['placeholder' => "Établissement"]])
            ->add('formation', TextType::class, ['attr' => ['placeholder' => "Formation"]])
            ->add('email', EmailType::class, ['attr' => ['placeholder' => "Email"]])
            ->add('description', TextareaType::class, ['attr' => ['placeholder' => "Dites nous tout sur vous et vos points forts"]]);
    }
    
    /**
     * {@inheritdoc}
     */
    public function configureOptions(OptionsResolver $resolver)
    {
        $resolver->setDefaults(array(
            'data_class' => 'UserBundle\Entity\Register'
        ));
    }

    /**
     * {@inheritdoc}
     */
    public function getBlockPrefix()
    {
        return 'userbundle_register';
    }


}
