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
        // just setup a fresh $task object (remove the dummy data)
        $beer = new Beer();

        $form = $this->createForm(BeerType::class, $beer);

        $form->handleRequest($request);
        $task = $form->getData();

        if ($form->isSubmitted() && $form->isValid()) {
          $em = $this->getDoctrine()->getManager();
          $em->persist($task);
          $em->flush();
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
        // just setup a fresh $task object (remove the dummy data)
        $entityManager = $this->getDoctrine()->getManager();
        $beer = $entityManager->getRepository(Beer::class)->find($id);

        if (!$beer) {
          throw $this->createNotFoundException(
              'No beer found for this id '.$id
            );
        }
        $form = $this->createForm(BeerType::class, $beer);

        $form->handleRequest($request);
        $task = $form->getData();

        if ($form->isSubmitted() && $form->isValid()) {
          $entityManager = $this->getDoctrine()->getManager();
          $entityManager->persist($task);
          $entityManager->flush();
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
        // just setup a fresh $task object (remove the dummy data)
        $entityManager = $this->getDoctrine()->getManager();
        $beer = $entityManager->getRepository(Beer::class)->find($id);

        if (!$beer) {
          throw $this->createNotFoundException(
              'No beers found for this id '.$id
            );
          }

        $entityManager->remove($beer);
        $entityManager->flush();
        $this->addFlash(
          'notice',
          'The beer has been successfully deleted !'
        );
        return $this->redirectToRoute("beers");
    }
}
