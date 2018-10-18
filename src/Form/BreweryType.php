<?php

namespace App\Form;

use App\Entity\Brewery;
use App\Entity\Beer;
use Symfony\Component\Routing\Annotation\Route;
use Symfony\Component\Form\Extension\Core\Type\TextType;
use Symfony\Component\Form\Extension\Core\Type\SubmitType;
use Symfony\Component\Form\AbstractType;
use Symfony\Component\Form\FormBuilderInterface;
use Symfony\Component\OptionsResolver\OptionsResolver;
use Symfony\Component\Form\Extension\Core\Type\CollectionType;
use Symfony\Bridge\Doctrine\Form\Type\EntityType;

class BreweryType extends AbstractType
{
    public function buildForm(FormBuilderInterface $builder, array $options)
    {
        $builder
            ->add('name', TextType::class, array('label' => 'Name'))
            ->add('description', TextType::class, array('label' => 'Description'))
            ->add('website', TextType::class, array('label' => 'Website'))
            ->add('beers', EntityType::class, array(
              'label' => 'Beers',
              'class' => Beer::class,
              'choice_label' => 'name',
              'expanded'=>false,
              'multiple'=>true))
            ->add('save', SubmitType::class, array('label' => 'Save'))
            ->getForm();
        ;
    }

    public function configureOptions(OptionsResolver $resolver)
    {
        $resolver->setDefaults([
            'data_class' => Brewery::class,
        ]);
    }
}
