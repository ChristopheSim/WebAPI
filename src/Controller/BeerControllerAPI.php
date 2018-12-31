<?php

namespace App\Controller;

use Symfony\Bundle\FrameworkBundle\Controller\AbstractController;
use Symfony\Component\Routing\Annotation\Route;
use Symfony\Component\Form\Extension\Core\Type\TextType;
use Symfony\Component\Form\Extension\Core\Type\SubmitType;
use App\Entity\Type;
use App\Entity\Beer;
use App\Entity\Brewery;
use App\Form\BeerType;
use Symfony\Bridge\Doctrine\Form\Type\EntityType;
use Symfony\Component\HttpFoundation\Request;
use Symfony\Component\HttpFoundation\Response;
use Symfony\Component\HttpFoundation\JsonResponse;
use Symfony\Component\Serializer\Encoder\JsonEncoder;
use Symfony\Component\Serializer\Normalizer\ObjectNormalizer;
use Symfony\Component\Serializer\Serializer;


class BeerControllerAPI extends AbstractController
{
    /**
     * @Route("/api/beers", name="api_beers", methods={"GET"})
     */
    public function indexAction()
    {
      // get all beers
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
        // get beers
        $em = $this->getDoctrine()->getManager();
        $beers = $em->getRepository(Beer::class)->findAll();
        // encode the beers in JSON
        $jsonContent = $serializer->serialize($beers,'json');
        $response = new JsonResponse();
        $response->setContent($jsonContent);
        $response->headers->set('Content-Type', 'application/json');
        $response->headers->set('Access-Control-Allow-Origin', '*');
        return $response;
    }

    /**
     * @Route("/api/beers/get_beer/{id}", name="api_get_beer", methods={"GET"})
     */
    public function getBeerAction($id)
    {
      // get one beer (id)
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
      // get the beer
      $em = $this->getDoctrine()->getManager();
      if ($id != null) {
          $beer = $em->getRepository(Beer::class)
                      ->find($id);

          if ($beer != null) {
              // encode the beer in JSON
              $jsonContent = $serializer->serialize($beer, 'json');
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
     * @Route("/api/beers/add_beer", name="api_add_beer", methods={"GET", "POST", "OPTIONS"})
     */
    public function addBeerAction(Request $request)
    {
        // add one beer
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
        // create empty objects
        $beer = new Beer();
        $type = new Type();
        $brewery = new Brewery();
        // decode the JSON
        $json = $request->getContent();
        $content = json_decode($json, true);
        // set content of the beer object
        $beer->setName($content["name"]);
        $beer->setDescription($content["description"]);
        $beer->setVolume($content["volume"]);
        // set content of the type object
        $type = $this->getDoctrine()
            ->getRepository(Type::class)
            ->find($content['type']);
        $beer->setType($type);
        // set content of the brewery object
        $brewery = $this->getDoctrine()
            ->getRepository(Brewery::class)
            ->find($content['brewery']);
        $beer->setBrewery($brewery);

        if ($beer != null) {
          // save the beer object
          $em = $this->getDoctrine()->getManager();
          $em->persist($beer);
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
     * @Route("/api/beers/update_beer/{id}", name="api_update_beer", methods={"GET", "PUT", "OPTIONS"})
     */
    public function updateBeerAction(Request $request, $id)
    {
      // update one beer (id)
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
        // find the existing beer object
        $beer = $this->getDoctrine()
            ->getRepository(Beer::class)
            ->find($id);
        // create empty objects
        $type = new Type();
        $brewery = new Brewery();
        // set content of the beer object
        $beer->setName($content["name"]);
        $beer->setDescription($content["description"]);
        $beer->setVolume($content["volume"]);
        // find the existing type object
        $type = $this->getDoctrine()
            ->getRepository(Type::class)
            ->find($content['type']);
        $beer->setType($type);
        // find the existing brewery object
        $brewery = $this->getDoctrine()
            ->getRepository(Brewery::class)
            ->find($content['brewery']);
        $beer->setBrewery($brewery);

        if ($beer != null) {
          // save the beer object
          $em = $this->getDoctrine()->getManager();
          $em->persist($beer);
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
     * @Route("/api/beers/delete_beer/{id}", name="api_delete_beer", methods={"GET", "DELETE", "OPTIONS"})
     */
    public function deleteBeerAction(Request $request, $id)
    {
        // delete one beer (id)
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
          $beer = $entityManager->getRepository(Beer::class)->find($id);
          $entityManager->remove($beer);
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
