<?php

namespace App\Controller;

use Symfony\Bundle\FrameworkBundle\Controller\AbstractController;
use Symfony\Component\Routing\Annotation\Route;
use Symfony\Component\Form\Extension\Core\Type\TextType;
use Symfony\Component\Form\Extension\Core\Type\SubmitType;
use App\Entity\Brewery;
use App\Entity\Beer;
use App\Form\BreweryType;
use Symfony\Bridge\Doctrine\Form\Type\EntityType;
use Symfony\Component\Form\Extension\Core\Type\CollectionType;
use Symfony\Component\HttpFoundation\Request;
use Symfony\Component\HttpFoundation\Response;

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

        $form = $this->createForm(BreweryType::class, $brewery);

        $form->handleRequest($request);
        $task = $form->getData();

        if ($form->isSubmitted() && $form->isValid()) {
          $em = $this->getDoctrine()->getManager();
          $em->persist($task);
          $em->flush();
          return new Response('The brewery has been successfully added !');
        }

        return $this->render('brewery/add_brewery.html.twig', array('controller_name' => 'AddBreweryFunction', 'form' => $form->createView()));
    }
}
