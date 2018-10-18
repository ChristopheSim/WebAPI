<?php

namespace App\Controller;

use Symfony\Bundle\FrameworkBundle\Controller\AbstractController;
use Symfony\Component\Routing\Annotation\Route;
use Symfony\Component\Form\Extension\Core\Type\TextType;
use Symfony\Component\Form\Extension\Core\Type\SubmitType;
use App\Entity\Type;
use App\Entity\Beer;
use App\Entity\Brewery;
use App\Form\BeerType;
use Symfony\Bridge\Doctrine\Form\Type\EntityType;
use Symfony\Component\HttpFoundation\Request;
use Symfony\Component\HttpFoundation\Response;

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

        $form = $this->createForm(BeerType::class, $beer);

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
