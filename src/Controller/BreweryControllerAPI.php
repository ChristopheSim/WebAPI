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
use Symfony\Component\HttpFoundation\JsonResponse;
use Symfony\Component\Serializer\Encoder\JsonEncoder;
use Symfony\Component\Serializer\Normalizer\ObjectNormalizer;
use Symfony\Component\Serializer\Serializer;


class BreweryControllerAPI extends AbstractController
{
    /**
     * @Route("/api/breweries", name="api_breweries", methods={"GET"})
     */
    public function indexAction()
    {
        // get all breweries
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
        // get breweries
        $em = $this->getDoctrine()->getManager();
        $breweries = $em->getRepository(Brewery::class)->findAll();
        // encode the breweries in JSON
        $jsonContent = $serializer->serialize($breweries,'json');
        $response = new JsonResponse();
        $response->setContent($jsonContent);
        $response->headers->set('Content-Type', 'application/json');
        $response->headers->set('Access-Control-Allow-Origin', '*');
        return $response;
    }

    /**
     * @Route("/api/breweries/get_brewery/{id}", name="api_get_brewery", methods={"GET"})
     */
    public function getBreweryAction($id)
    {
      // get one brewery (id)
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
      // get the brewery
      $em = $this->getDoctrine()->getManager();
      if ($id != null) {
          $brewery = $em->getRepository(Brewery::class)
                        ->find($id);

          if ($brewery != null) {
              // encode the brewery in JSON
              $jsonContent = $serializer->serialize($brewery, 'json');
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
     * @Route("/api/breweries/add_brewery", name="api_add_brewery", methods={"GET", "POST", "OPTIONS"})
     */
    public function addBreweryAction(Request $request)
    {
        // add one brewery
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
        $brewery = new Brewery();
        // decode the JSON
        $json = $request->getContent();
        $content = json_decode($json, true);
        // set content of the brewery object
        $brewery->setName($content["name"]);
        $brewery->setDescription($content["description"]);
        $brewery->setWebsite($content["website"]);

        if ($brewery != null) {
          // save the brewery object
          $em = $this->getDoctrine()->getManager();
          $em->persist($brewery);
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
     * @Route("/api/breweries/update_brewery/{id}", name="api_update_brewery", methods={"GET", "PUT", "OPTIONS"})
     */
    public function updateBreweryAction(Request $request, $id)
    {
        // update one brewery (id)
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
        // find the existing brewery object
        $brewery = $this->getDoctrine()
            ->getRepository(Brewery::class)
            ->find($id);
        // set content of the brewery object
        $brewery->setName($content["name"]);
        $brewery->setDescription($content["description"]);
        $brewery->setWebsite($content["website"]);

        $em = $this->getDoctrine()->getManager();

        if ($brewery != null) {
          // save the brewery object
          $em = $this->getDoctrine()->getManager();
          $em->persist($brewery);
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
     * @Route("/api/breweries/delete_brewery/{id}", name="api_delete_brewery", methods={"GET", "DELETE", "OPTIONS"})
     */
    public function deleteBreweryAction(Request $request, $id)
    {
        // delete one brewery (id)
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
          $brewery = $entityManager->getRepository(Brewery::class)->find($id);
          $entityManager->remove($brewery);
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
