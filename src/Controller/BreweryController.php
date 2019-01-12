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
        // find all breweries
        $breweries = $this->getDoctrine()->getRepository(Brewery::class)->findAll();
        return $this->render('brewery/index.html.twig', [
            'controller_name' => 'BreweryController',
            'breweries' => $breweries,
        ]);
    }

    /**
     * @Route("/breweries/add_brewery", name="add_brewery")
     */
    public function addBreweryAction(Request $request)
    {
        // create an empty brewery object
        $brewery = new Brewery();

        $form = $this->createForm(BreweryType::class, $brewery);

        $form->handleRequest($request);
        $task = $form->getData();

        if ($form->isSubmitted() && $form->isValid()) {
          $em = $this->getDoctrine()->getManager();
          $em->persist($task);
          $em->flush();
          // add a flash message
          $this->addFlash(
            'notice',
            'The brewery has been successfully added !'
          );
          return $this->redirectToRoute("breweries");
        }

        return $this->render('brewery/add_brewery.html.twig', array('controller_name' => 'AddBreweryFunction', 'form' => $form->createView()));
    }


    /**
     * @Route("/breweries/update_brewery/{id}", name="update_brewery")
     */
    public function updateBreweryAction(Request $request, $id)
    {
        // find the brewery object
        $entityManager = $this->getDoctrine()->getManager();
        $brewery = $entityManager->getRepository(Brewery::class)->find($id);
        // create a form with the brewery data
        if (!$brewery) {
          throw $this->createNotFoundException(
              'No brewery found for this id '.$id
            );
        }

        $form = $this->createForm(BreweryType::class, $brewery);
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
            'The brewery has been successfully updated !'
          );
          return $this->redirectToRoute("breweries");
        }
        return $this->render('brewery/add_brewery.html.twig', array('controller_name' => 'UpdateBreweryFunction', 'form' => $form->createView()));
    }


    /**
     * @Route("/breweries/delete_brewery/{id}", name="delete_brewery")
     */
    public function deleteBreweryAction(Request $request, $id)
    {
        // find the brewery object
        $entityManager = $this->getDoctrine()->getManager();
        $brewery = $entityManager->getRepository(Brewery::class)->find($id);

        if (!$brewery) {
          throw $this->createNotFoundException(
              'No brewery found for this id '.$id
            );
        }
        // delete the brewery
        $entityManager->remove($brewery);
        $entityManager->flush();
        // add a flash message
        $this->addFlash(
          'notice',
          'The brewery has been successfully deleted !'
        );
        return $this->redirectToRoute("breweries");
    }
}
