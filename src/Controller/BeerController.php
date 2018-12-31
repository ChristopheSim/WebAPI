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
        // find all beers
        $beers = $this->getDoctrine()->getRepository(Beer::class)->findAll();
        return $this->render('beer/index.html.twig', [
            'controller_name' => 'BeerController',
            'beers' => $beers,
        ]);
    }

    /**
     * @Route("/beers/add_beer", name="add_beer")
     */
    public function addBeerAction(Request $request)
    {
        // create an empty beer object
        $beer = new Beer();
        // create an empty form
        $form = $this->createForm(BeerType::class, $beer);
        // get data from the form
        $form->handleRequest($request);
        $task = $form->getData();
        // save the beer
        if ($form->isSubmitted() && $form->isValid()) {
          $em = $this->getDoctrine()->getManager();
          $em->persist($task);
          $em->flush();
          // add a flash message
          $this->addFlash(
            'notice',
            'The beer has been successfully added !'
          );
          return $this->redirectToRoute("beers");
        }

        return $this->render('beer/add_beer.html.twig', array('controller_name' => 'AddBeerFunction', 'form' => $form->createView()));
    }


    /**
     * @Route("/beers/update_beer/{id}", name="update_beer")
     */
    public function updateBeerAction(Request $request, $id)
    {
        // find the beer object
        $entityManager = $this->getDoctrine()->getManager();
        $beer = $entityManager->getRepository(Beer::class)->find($id);
        // create a form with the beer data
        if (!$beer) {
          throw $this->createNotFoundException(
              'No beer found for this id '.$id
            );
        }
        $form = $this->createForm(BeerType::class, $beer);
        // get data from the form
        $form->handleRequest($request);
        $task = $form->getData();
        // get data from the form
        if ($form->isSubmitted() && $form->isValid()) {
          $entityManager = $this->getDoctrine()->getManager();
          $entityManager->persist($task);
          $entityManager->flush();
          // add a flash message
          $this->addFlash(
            'notice',
            'The beer has been successfully updated !'
          );
          return $this->redirectToRoute("beers");
        }
        return $this->render('beer/add_beer.html.twig', array('controller_name' => 'UpdateBeerFunction', 'form' => $form->createView()));
    }


    /**
     * @Route("/beers/delete_beer/{id}", name="delete_beer")
     */
    public function deleteBeerAction(Request $request, $id)
    {
        // find the beer object
        $entityManager = $this->getDoctrine()->getManager();
        $beer = $entityManager->getRepository(Beer::class)->find($id);

        if (!$beer) {
          throw $this->createNotFoundException(
              'No beers found for this id '.$id
            );
        }
        // delete the beer
        $entityManager->remove($beer);
        $entityManager->flush();
        // add a flash message
        $this->addFlash(
          'notice',
          'The beer has been successfully deleted !'
        );
        return $this->redirectToRoute("beers");
    }
}
