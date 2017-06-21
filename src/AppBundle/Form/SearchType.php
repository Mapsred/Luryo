<?php

namespace AppBundle\Form;

use Symfony\Component\Form\AbstractType;
use Symfony\Component\Form\Extension\Core\Type\ChoiceType;
use Symfony\Component\Form\Extension\Core\Type\DateType;
use Symfony\Component\Form\Extension\Core\Type\IntegerType;
use Symfony\Component\Form\Extension\Core\Type\TextType;
use Symfony\Component\Form\FormBuilderInterface;
use Symfony\Component\OptionsResolver\OptionsResolver;

class SearchType extends AbstractType
{
    /**
     * {@inheritdoc}
     */
    public function buildForm(FormBuilderInterface $builder, array $options)
    {
        $builder
            ->add('location', ChoiceType::class, ['mapped' => false, 'label' => "Ou", "required" => "false"])
            ->add('date', DateType::class, ['label' => "Quand", "required" => "false", 'widget' => 'single_text'])
            ->add('price', IntegerType::class, ['label' => "Prix", "required" => "false"])
            ->add('choice', TextType::class, ['label' => "Votre choix", "required" => "false"])
            ->add("sort", TextType::class, ["required" => false, "empty_data" => "date", "attr" => ['class' => "hidden"]])
            ->add("order", TextType::class, ["required" => false, "empty_data" => "ASC", "attr" => ['class' => "hidden"]])
            ->get('location')->resetViewTransformers();
    }

    /**
     * {@inheritdoc}
     */
    public function configureOptions(OptionsResolver $resolver)
    {
        $resolver->setDefaults(['data_class' => 'AppBundle\Entity\Search', 'csrf_protection' => false]);
    }

    /**
     * {@inheritdoc}
     */
    public function getBlockPrefix()
    {
        return 'search';
    }
}
