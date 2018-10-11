<?php

namespace App\Controller;

use Symfony\Bundle\FrameworkBundle\Controller\AbstractController;
use Symfony\Component\Routing\Annotation\Route;
use Symfony\Component\Form\Extension\Core\Type\TextType;
use Symfony\Component\Form\Extension\Core\Type\SubmitType;
use App\Entity\User;
use Symfony\Bridge\Doctrine\Form\Type\EntityType;
use Symfony\Component\HttpFoundation\Request;

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

        $form = $this->createFormBuilder($type)
          ->add('name', TextType::class, array('label' => 'Name'))
          ->add('description', TextType::class, array('label' => 'Description'))
          ->add('beers', EntityType::class, array(
            'label' => 'Beers',
            'class' => Beer::class,
            'choice_label' => 'beers'))
          ->add('save', SubmitType::class, array('label' => 'Save'))
          ->getForm();

        $form->handleRequest($request);
        $task = $form->getData();

        if ($form->isValid()) {
          $em = $this->getDoctrine()->getManager();
          $em->persist($task);
          $em->flush();
          return new Response('The type is successfully added !');
        }

        return $this->render('AcmeAccountBundle:Account:add_type.html.twig', array('controller_name' => 'AddTypeFunction', 'form' => $form->createView()));
    }

}
