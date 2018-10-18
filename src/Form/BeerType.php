<?php

namespace App\Form;

use App\Entity\Beer;
use App\Entity\Brewery;
use App\Entity\Type;
use Symfony\Component\Routing\Annotation\Route;
use Symfony\Component\Form\Extension\Core\Type\TextType;
use Symfony\Component\Form\Extension\Core\Type\SubmitType;
use Symfony\Component\Form\AbstractType;
use Symfony\Component\Form\FormBuilderInterface;
use Symfony\Component\OptionsResolver\OptionsResolver;
use Symfony\Component\Form\Extension\Core\Type\CollectionType;
use Symfony\Bridge\Doctrine\Form\Type\EntityType;

class BeerType extends AbstractType
{
    public function buildForm(FormBuilderInterface $builder, array $options)
    {
        $builder
            ->add('name', TextType::class, array('label' => 'Name'))
            ->add('description', TextType::class, array('label' => 'Description'))
            ->add('volume', TextType::class, array('label' => 'Volume'))
            ->add('type', EntityType::class, array(
              'label' => 'Type',
              'class' => Type::class,
              'choice_label' => 'name'))
            ->add('brewery', EntityType::class, array(
                'label' => 'Brewery',
                'class' => Brewery::class,
                'choice_label' => 'name'))
            ->add('save', SubmitType::class, array('label' => 'Save'))
            ->getForm();
        ;
    }

    public function configureOptions(OptionsResolver $resolver)
    {
        $resolver->setDefaults([
            'data_class' => Beer::class,
        ]);
    }
}
