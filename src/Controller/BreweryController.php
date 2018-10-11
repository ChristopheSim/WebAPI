<?php

namespace App\Controller;

use Symfony\Bundle\FrameworkBundle\Controller\AbstractController;
use Symfony\Component\Routing\Annotation\Route;
use Symfony\Component\Form\Extension\Core\Type\TextType;
use Symfony\Component\Form\Extension\Core\Type\SubmitType;
use App\Entity\User;
use App\Entity\Brewery;
use App\Entity\Beer;
use Symfony\Bridge\Doctrine\Form\Type\EntityType;
use Symfony\Component\HttpFoundation\Request;

class BreweryController extends AbstractController
{
    /**
     * @Route("/breweries", name="breweries")
     */
    public function indexAction()
    {
        return $this->render('brewery/index.html.twig', [
            'controller_name' => 'BreweryController',
        ]);
    }

    /**
     * @Route("/breweries/add_brewery", name="add_brewery")
     */
    public function addBreweryAction(Request $request)
    {
        // just setup a fresh $task object (remove the dummy data)
        $brewery = new Brewery();

        $form = $this->createFormBuilder($brewery)
          ->add('name', TextType::class, array('label' => 'Name'))
          ->add('description', TextType::class, array('label' => 'Description'))
          ->add('website', TextType::class, array('label' => 'Website'))
          ->add('beers', EntityType::class, array(
            'label' => 'Beers',
            'class' => Beer::class,
            'choice_label' => 'beers'))
          ->add('save', SubmitType::class, array('label' => 'Save'))
          ->getForm();

        $form->handleRequest($request);
        $task = $form->getData();

        if ($form->isSubmitted() && $form->isValid()) {
          $em = $this->getDoctrine()->getManager();
          $em->persist($task);
          $em->flush();
          return new Response('The brewery has been successfully added !');
        }

        return $this->render('brewery/add_brewery.html.twig', array('controller_name' => 'AddTypeFunction', 'form' => $form->createView()));
    }
}
