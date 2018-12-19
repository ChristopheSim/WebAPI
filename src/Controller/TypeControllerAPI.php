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
        // just setup a fresh object (remove the dummy data)
        if ($_SERVER['REQUEST_METHOD'] == 'OPTIONS')
        {
            $response->headers->set('Content-Type', 'application/text');
            $response->headers->set('Access-Control-Allow-Origin', '*');
            $response->headers->set('Access-Control-Allow-Methods', 'GET, PUT, POST, DELETE, OPTIONS');
            $response->headers->set('Access-Control-Allow-Headers', 'Content-Type',true);

            return $response;
        }

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
        $response->headers->set('Content-Type', 'application/json');
        $response->headers->set('Access-Control-Allow-Origin', '*');
        return $response;
    }

    /**
     * @Route("/api/types/get_type/{id}", name="api_get_type", methods={"GET"})
     */
    public function getTypeAction($id)
    {
      // just setup a fresh object (remove the dummy data)
      if ($_SERVER['REQUEST_METHOD'] == 'OPTIONS')
      {
          $response->headers->set('Content-Type', 'application/text');
          $response->headers->set('Access-Control-Allow-Origin', '*');
          $response->headers->set('Access-Control-Allow-Methods', 'GET, PUT, POST, DELETE, OPTIONS');
          $response->headers->set('Access-Control-Allow-Headers', 'Content-Type',true);

          return $response;
      }

      $response = new Response();
      $normalizer = new ObjectNormalizer();
      $normalizer->setCircularReferenceLimit(1);
      $normalizer->setCircularReferenceHandler(function ($object) {
        return $object->getId();
      });

      $encoders = array(new JsonEncoder());
      $normalizers = array($normalizer);
      $serializer = new Serializer($normalizers, $encoders);
      $em = $this->getDoctrine()->getManager();
      if ($id != null) {
          $type = $em->getRepository(Type::class)
                      ->find($id);

          if ($type != null) {
              $jsonContent = $serializer->serialize($type, 'json');
              $response->setContent($jsonContent);
              $response->headers->set('Content-Type', 'application/json');
              $response->setStatusCode('200');
          }
          else {
              $response->setStatusCode('404');
          }
      }
      else {
          $response->setStatusCode('404');
      }
      $response->headers->set('Content-Type', 'application/json');
      $response->headers->set('Access-Control-Allow-Origin', '*');
      return $response;
    }

    /**
     * @Route("/api/types/add_type", name="api_add_type", methods={"GET", "POST", "OPTIONS"})
     */
    public function addTypeAction(Request $request)
    {
        $response = new Response();
        $query = array();
        // just setup a fresh object (remove the dummy data)
        if ($_SERVER['REQUEST_METHOD'] == 'OPTIONS')
        {
            $response->headers->set('Content-Type', 'application/text');
            $response->headers->set('Access-Control-Allow-Origin', '*');
            $response->headers->set('Access-Control-Allow-Methods', 'GET, PUT, POST, DELETE, OPTIONS');
            $response->headers->set('Access-Control-Allow-Headers', 'Content-Type',true);

            return $response;
        }

        $type = new Type();

        $json = $request->getContent();
        $content = json_decode($json, true);

        $type->setName($content["name"]);
        $type->setDescription($content["description"]);
/*
        foreach ($content["beers"] as $beer_id) {
          $em = $this->getDoctrine()->getManager();
          $beer = $this->getRepository(Beer::class)->find($beer_id);
          if (!$beer) {
            throw $this->createNotFoundException(
              'No beer found for this beer id '.$beer_id
            );
          }
          $type->addBeer($beer);
        }
*/
        if ($type != null) {
          $em = $this->getDoctrine()->getManager();
          $em->persist($type);
          $em->flush();
          $response->setStatusCode('200');
          $query['status'] = true;
        }
        else {
          $response->setStatusCode('404');
          $query['status'] = false;
        }
        $response->headers->set('Access-Control-Allow-Origin', '*');
        $response->headers->set('Content-Type', 'application/json');
        $response->setContent(json_encode($query));
        return $response;
    }


    /**
     * @Route("/api/types/update_type/{id}", name="api_update_type", methods={"GET", "PUT", "OPTIONS"})
     */
    public function updateTypeAction(Request $request, $id)
    {
        $response = new Response();
        $query = array();
        // just setup a fresh object (remove the dummy data)
        if ($_SERVER['REQUEST_METHOD'] == 'OPTIONS')
        {
            $response->headers->set('Content-Type', 'application/text');
            $response->headers->set('Access-Control-Allow-Origin', '*');
            $response->headers->set('Access-Control-Allow-Methods', 'GET, PUT, POST, DELETE, OPTIONS');
            $response->headers->set('Access-Control-Allow-Headers', 'Content-Type',true);

            return $response;
        }

        $json = $request->getContent();
        $content = json_decode($json, true);

        $type = $this->getDoctrine()
            ->getRepository(Type::class)
            ->find($id);

        $type->setName($content["name"]);
        $type->setDescription($content["description"]);
/*
        foreach ($content["beers"] as $beer_id) {
          $em = $this->getDoctrine()->getManager();
          $beer = $this->getRepository(Beer::class)->find($beer_id);
          if (!$beer) {
            throw $this->createNotFoundException(
              'No beer found for this beer id '.$beer_id
            );
          }
          $type->addBeer($beer);
        }
*/
        if ($type != null) {
          $em = $this->getDoctrine()->getManager();
          $em->persist($type);
          $em->flush();
          $response->setStatusCode('200');
          $query['status'] = true;
        }
        else {
          $response->setStatusCode('404');
          $query['status'] = false;
        }
        $response->headers->set('Access-Control-Allow-Origin', '*');
        $response->headers->set('Content-Type', 'application/json');
        $response->setContent(json_encode($query));
        return $response;
    }

    /**
     * @Route("/api/types/delete_type/{id}", name="api_delete_type", methods={"GET", "DELETE", "OPTIONS"})
     */
    public function deleteTypeAction(Request $request, $id)
    {
        $response = new Response();
        $query = array();
        // just setup a fresh object (remove the dummy data)
        if ($_SERVER['REQUEST_METHOD'] == 'OPTIONS')
        {
            $response->headers->set('Content-Type', 'application/text');
            $response->headers->set('Access-Control-Allow-Origin', '*');
            $response->headers->set('Access-Control-Allow-Methods', 'GET, PUT, POST, DELETE, OPTIONS');
            $response->headers->set('Access-Control-Allow-Headers', 'Content-Type',true);

            return $response;
        }

        if ($id != null) {
          $entityManager = $this->getDoctrine()->getManager();
          $type = $entityManager->getRepository(Type::class)->find($id);
          $entityManager->remove($type);
          $entityManager->flush();
          $response->setStatusCode('200');
          $query['status'] = true;
        } else {
          $response->setStatusCode('404');
          $query['status'] = false;
        }
        $response->headers->set('Access-Control-Allow-Origin', '*');
        $response->headers->set('Content-Type', 'application/json');
        $response->setContent(json_encode($query));
        return $response;
    }
}
