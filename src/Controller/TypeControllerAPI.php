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
        // get all types
        if ($_SERVER['REQUEST_METHOD'] == 'OPTIONS')
        {
            $response->headers->set('Content-Type', 'application/text');
            $response->headers->set('Access-Control-Allow-Origin', '*');
            $response->headers->set('Access-Control-Allow-Methods', 'GET, PUT, POST, DELETE, OPTIONS');
            $response->headers->set('Access-Control-Allow-Headers', 'Content-Type',true);

            return $response;
        }
        // stop the loop with circular reference
        $normalizer = new ObjectNormalizer();
        $normalizer->setCircularReferenceLimit(1);
        $normalizer->setCircularReferenceHandler(function ($object) {
          return $object->getId();
        });
        $encoders = array(new JsonEncoder());
        $normalizers = array($normalizer);
        $serializer = new Serializer($normalizers, $encoders);
        // get types
        $em = $this->getDoctrine()->getManager();
        $types = $em->getRepository(Type::class)->findAll();
        // encode the types in JSON
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
      // get one type (id)
      if ($_SERVER['REQUEST_METHOD'] == 'OPTIONS')
      {
          $response->headers->set('Content-Type', 'application/text');
          $response->headers->set('Access-Control-Allow-Origin', '*');
          $response->headers->set('Access-Control-Allow-Methods', 'GET, PUT, POST, DELETE, OPTIONS');
          $response->headers->set('Access-Control-Allow-Headers', 'Content-Type',true);

          return $response;
      }
      // stop the loop with circular reference
      $response = new Response();
      $normalizer = new ObjectNormalizer();
      $normalizer->setCircularReferenceLimit(1);
      $normalizer->setCircularReferenceHandler(function ($object) {
        return $object->getId();
      });

      $encoders = array(new JsonEncoder());
      $normalizers = array($normalizer);
      $serializer = new Serializer($normalizers, $encoders);
      // get the type
      $em = $this->getDoctrine()->getManager();
      if ($id != null) {
          $type = $em->getRepository(Type::class)
                      ->find($id);

          if ($type != null) {
              // encode the type in JSON
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
        // add one type
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
        // create empty object
        $type = new Type();
        // decode the JSON
        $json = $request->getContent();
        $content = json_decode($json, true);
        // set content of the type object
        $type->setName($content["name"]);
        $type->setDescription($content["description"]);

        if ($type != null) {
          // save the type object
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
        // update one type (id)
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
        // decode the JSON
        $json = $request->getContent();
        $content = json_decode($json, true);
        // find the existing type object
        $type = $this->getDoctrine()
            ->getRepository(Type::class)
            ->find($id);
        // set content of the type object
        $type->setName($content["name"]);
        $type->setDescription($content["description"]);

        if ($type != null) {
          // save the type object
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
        // delete one type (id)
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
