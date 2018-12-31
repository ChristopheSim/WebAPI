<?php

namespace App\Controller;

use Symfony\Bundle\FrameworkBundle\Controller\AbstractController;
use Symfony\Component\Routing\Annotation\Route;
use Symfony\Component\Form\Extension\Core\Type\TextType;
use Symfony\Component\Form\Extension\Core\Type\SubmitType;
use App\Entity\Type;
use App\Entity\Beer;
use App\Form\TypeType;
use Symfony\Bridge\Doctrine\Form\Type\EntityType;
use Symfony\Component\Form\Extension\Core\Type\CollectionType;
use Symfony\Component\HttpFoundation\Request;
use Symfony\Component\HttpFoundation\Response;

class TypeController extends AbstractController
{
    /**
     * @Route("/types", name="types")
     */
    public function indexAction()
    {
        // find all types of beers
        $types = $this->getDoctrine()->getRepository(Type::class)->findAll();
        return $this->render('type/index.html.twig', [
            'controller_name' => 'TypeController',
            'types' => $types,
        ]);
    }

    /**
     * @Route("/types/add_type", name="add_type")
     */
    public function addTypeAction(Request $request)just setup a fresh $task object (remove the dummy data)
    {
        // create an empty type object
        $type = new Type();

        $form = $this->createForm(TypeType::class, $type);

        $form->handleRequest($request);
        $task = $form->getData();

        if ($form->isSubmitted() && $form->isValid()) {
          $em = $this->getDoctrine()->getManager();
          $em->persist($task);
          $em->flush();
          // add a flash message
          $this->addFlash(
            'notice',
            'The type has been successfully added !'
          );
          return $this->redirectToRoute("types");
        }

        return $this->render('type/add_type.html.twig', array('controller_name' => 'AddTypeFunction', 'form' => $form->createView()));
    }


    /**
     * @Route("/types/update_type/{id}", name="update_type")
     */
    public function updateTypeAction(Request $request, $id)
    {
        // find the type object
        $entityManager = $this->getDoctrine()->getManager();
        $type = $entityManager->getRepository(Type::class)->find($id);
        // create a form with the type data
        if (!$type) {
          throw $this->createNotFoundException(
              'No type found for this id '.$id
            );
        }
        $form = $this->createForm(TypeType::class, $type);
        // get data from the form
        $form->handleRequest($request);
        $task = $form->getData();
        // get data from the form
        if ($form->isSubmitted() && $form->isValid()) {
          $entityManager = $this->getDoctrine()->getManager();
          $entityManager->persist($task);
          $entityManager->flush();
          $this->addFlash(
            'notice',
            'The type has been successfully updated !'
          );
          return $this->redirectToRoute("types");
        }
        return $this->render('type/add_type.html.twig', array('controller_name' => 'UpdateTypeFunction', 'form' => $form->createView()));
    }

    /**
     * @Route("/types/delete_type/{id}", name="delete_type")
     */
    public function deleteTypeAction(Request $request, $id)
    {
        // find the type object
        $entityManager = $this->getDoctrine()->getManager();
        $type = $entityManager->getRepository(Type::class)->find($id);

        if (!$type) {
          throw $this->createNotFoundException(
              'No type found for this id '.$id
            );
        }
        // delete the type
        $entityManager->remove($type);
        $entityManager->flush();
        $this->addFlash(
          'notice',
          'The type has been successfully deleted !'
        );
        return $this->redirectToRoute("types");
    }
}
