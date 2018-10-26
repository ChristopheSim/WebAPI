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
use Symfony\Component\HttpFoundation\JsonResponse;
use Symfony\Component\Serializer\Encoder\JsonEncoder;
use Symfony\Component\Serializer\Normalizer\ObjectNormalizer;
use Symfony\Component\Serializer\Serializer;

class TypeControllerAPI extends AbstractController
{
    /**
     * @Route("/api/types", name="api_types", methods={"GET"})
     */
    public function indexAction()
    {
        $normalizer = new ObjectNormalizer();
        $normalizer->setCircularReferenceLimit(1);
        $normalizer->setCircularReferenceHandler(function ($object) {
          return $object->getId();
        });
        $encoders = array(new JsonEncoder());
        $normalizers = array($normalizer);
        $serializer = new Serializer($normalizers, $encoders);
        $em = $this->getDoctrine()->getManager();
        $types = $em->getRepository(Type::class)->findAll();
        $jsonContent = $serializer->serialize($types,'json');
        $response = new JsonResponse();
        $response->setContent($jsonContent);
        return $response;
    }

    /**
     * @Route("/api/types/add_type", name="api_add_type", methods={"POST"}))
     */
    public function addTypeAction(Request $request)
    {
        // just setup a fresh $task object (remove the dummy data)
        if ($_SERVER['REQUEST_METHOD'] == 'OPTIONS')
        {
            $response = new Response();
            $response->headers->set('Access-Control-Allow-Origin', '*');
            $response->headers->set('Access-Control-Allow-Methods', 'GET, PUT, POST, DELETE, OPTIONS');

            return $response;
        }

        $type = new Type();

        $json = $request->getContent();
        $content = json_decode($json, true);

        $type->setName($content["name"]);
        $type->setDescription($content["description"]);

        $beer = new Beer();
        foreach ($content["beers"] as &$id_beer) {
          $beer = $this->getDoctrine()
            ->getRepository(Beer::class)
            ->find($id_beer);
          if (!$beer) {
            throw $this->createNotFoundException(
              'No beer found for this beer id '.$id_beer
            );
          }
          $type->addBeer($beer);
        }

        if (!$type) {
            return new Response("Error: type creation aborted !");
        }
        else {
            $em = $this->getDoctrine()->getManager();
            $em->persist($type);
            $em->flush();
            return new Response("The type was successfully added !");
        }
    }


    /**
     * @Route("/api/types/update_type/{id}", name="api_update_type", methods={"PUT"}))
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
     * @Route("/api/types/delete_type/{id}", name="api_delete_type", methods={"DELETE"}))
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
