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
        return $this->render('type/index.html.twig', [
            'controller_name' => 'TypeController',
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

}
