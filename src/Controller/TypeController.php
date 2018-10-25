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
        $types = $this->getDoctrine()->getRepository(Type::class)->findAll();
        return $this->render('type/index.html.twig', [
            'controller_name' => 'TypeController',
            'types' => $types,
        ]);
    }

    /**
     * @Route("/types/add_type", name="add_type")
     */
    public function addTypeAction(Request $request)
    {
        // just setup a fresh $task object (remove the dummy data)
        $type = new Type();

        $form = $this->createForm(TypeType::class, $type);

        $form->handleRequest($request);
        $task = $form->getData();

        if ($form->isSubmitted() && $form->isValid()) {
          $em = $this->getDoctrine()->getManager();
          $em->persist($task);
          $em->flush();
          return new Response('The type has been successfully added !');
        }

        return $this->render('type/add_type.html.twig', array('controller_name' => 'AddTypeFunction', 'form' => $form->createView()));
    }


    /**
     * @Route("/types/update_type/{id}", name="update_type")
     */
    public function updateTypeAction(Request $request, $id)
    {
        // just setup a fresh $task object (remove the dummy data)
        $entityManager = $this->getDoctrine()->getManager();
        $type = $entityManager->getRepository(Type::class)->find($id);

        if (!$type) {
          throw $this->createNotFoundException(
              'No type found for this id '.$id
            );
        }
        $form = $this->createForm(TypeType::class, $type);

        $form->handleRequest($request);
        $task = $form->getData();

        if ($form->isSubmitted() && $form->isValid()) {
          $entityManager = $this->getDoctrine()->getManager();
          $entityManager->persist($task);
          $entityManager->flush();
          return new Response('The type has been successfully updated !');
        }
        return $this->render('type/add_type.html.twig', array('controller_name' => 'UpdateTypeFunction', 'form' => $form->createView()));
    }

    /**
     * @Route("/types/delete_type/{id}", name="delete_type")
     */
    public function deleteTypeAction(Request $request, $id)
    {
        // just setup a fresh $task object (remove the dummy data)
        $entityManager = $this->getDoctrine()->getManager();
        $type = $entityManager->getRepository(Type::class)->find($id);

        if (!$type) {
          throw $this->createNotFoundException(
              'No type found for this id '.$id
            );
          }

        $entityManager->remove($type);
        $entityManager->flush();
        return $this->render('type/delete_type.html.twig', array('controller_name' => 'DeleteTypeFunction', 'explications' => "The type has been successfully deleted !"));
    }
}
