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


    /**
     * @Route("/breweries/update_brewery/{id}", name="update_brewery")
     */
    public function updateBreweryAction(Request $request, $id)
    {
        // just setup a fresh $task object (remove the dummy data)
        $entityManager = $this->getDoctrine()->getManager();
        $brewery = $entityManager->getRepository(Brewery::class)->find($id);

        if (!$brewery) {
          throw $this->createNotFoundException(
              'No brewery found for this id '.$id
            );
        }

        $form = $this->createForm(BreweryType::class, $brewery);

        $form->handleRequest($request);
        $task = $form->getData();

        if ($form->isSubmitted() && $form->isValid()) {
          $entityManager = $this->getDoctrine()->getManager();
          $entityManager->persist($task);
          $entityManager->flush();
          return new Response('The brewery has been successfully updated !');
        }
        return $this->render('brewery/add_brewery.html.twig', array('controller_name' => 'UpdateBreweryFunction', 'form' => $form->createView()));
    }


    /**
     * @Route("/breweries/delete_brewery/{id}", name="delete_brewery")
     */
    public function deleteBreweryAction(Request $request, $id)
    {
        // just setup a fresh $task object (remove the dummy data)
        $entityManager = $this->getDoctrine()->getManager();
        $brewery = $entityManager->getRepository(Brewery::class)->find($id);

        if (!$brewery) {
          throw $this->createNotFoundException(
              'No brewery found for this id '.$id
            );
          }

        $entityManager->remove($brewery);
        $entityManager->flush();
        return $this->render('brewery/delete_brewery.html.twig', array('controller_name' => 'DeleteBreweryFunction', 'explications' => "The brewery has been successfully deleted !"));
    }
}
