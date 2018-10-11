<?php

namespace App\Controller;

use Symfony\Bundle\FrameworkBundle\Controller\AbstractController;
use Symfony\Component\Routing\Annotation\Route;
use Symfony\Component\Form\Extension\Core\Type\TextType;
use Symfony\Component\Form\Extension\Core\Type\SubmitType;
use App\Entity\User;
use App\Entity\Type;
use App\Entity\Beer;
use App\Entity\Brewery;
use Symfony\Bridge\Doctrine\Form\Type\EntityType;
use Symfony\Component\HttpFoundation\Request;

class BeerController extends AbstractController
{
    /**
     * @Route("/beers", name="beers")
     */
    public function indexAction()
    {
        return $this->render('beer/index.html.twig', [
            'controller_name' => 'BeerController',
        ]);
    }

    /**
     * @Route("/beers/add_beer", name="add_beer")
     */
    public function addBeerAction(Request $request)
    {
        // just setup a fresh $task object (remove the dummy data)
        $beer = new Beer();

        $form = $this->createFormBuilder($beer)
          ->add('name', TextType::class, array('label' => 'Name'))
          ->add('description', TextType::class, array('label' => 'Description'))
          ->add('volume', TextType::class, array('label' => 'Volume'))
          ->add('type', EntityType::class, array(
            'label' => 'Type',
            'class' => Type::class,
            'choice_label' => 'type'))
            ->add('brewery', EntityType::class, array(
              'label' => 'Brewery',
              'class' => Brewery::class,
              'choice_label' => 'brewery'))
          ->add('save', SubmitType::class, array('label' => 'Save'))
          ->getForm();

        $form->handleRequest($request);
        $task = $form->getData();

        if ($form->isSubmitted() && $form->isValid()) {
          $em = $this->getDoctrine()->getManager();
          $em->persist($task);
          $em->flush();
          return new Response('The beer has been successfully added !');
        }

        return $this->render('beer/add_beer.html.twig', array('controller_name' => 'AddTypeFunction', 'form' => $form->createView()));
    }
}
