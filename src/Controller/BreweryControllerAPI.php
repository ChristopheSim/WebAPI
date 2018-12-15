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

header("Access-Control-Allow-Origin: *");

class BreweryControllerAPI extends AbstractController
{
    /**
     * @Route("/api/breweries", name="api_breweries", methods={"GET"})
     */
    public function indexAction()
    {
        if ($_SERVER['REQUEST_METHOD'] == 'OPTIONS')
        {
            $response = new Response();
            $response->headers->set('Access-Control-Allow-Origin', '*');
            $response->headers->set('Access-Control-Allow-Methods', 'GET, PUT, POST, DELETE, OPTIONS');

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
        $breweries = $em->getRepository(Brewery::class)->findAll();
        $jsonContent = $serializer->serialize($breweries,'json');
        $response = new JsonResponse();
        $response->setContent($jsonContent);
        return $response;
    }

    /**
     * @Route("/api/breweries/get_brewery/{id}", name="api_get_brewery", methods={"GET"}))
     */
    public function getBreweryAction($id)
    {
      if ($_SERVER['REQUEST_METHOD'] == 'OPTIONS')
      {
          $response = new Response();
          $response->headers->set('Access-Control-Allow-Origin', '*');
          $response->headers->set('Access-Control-Allow-Methods', 'GET, PUT, POST, DELETE, OPTIONS');

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
          $brewery = $em->getRepository(Brewery::class)
                        ->find($id);

          if ($brewery != null) {
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
      return $response;
    }


    /**
     * @Route("/api/breweries/add_brewery", name="api_add_brewery", methods={"POST"}))
     */
    public function addBreweryAction(Request $request)
    {
        // just setup a fresh $task object (remove the dummy data)
        if ($_SERVER['REQUEST_METHOD'] == 'OPTIONS')
        {
            $response = new Response();
            $response->headers->set('Access-Control-Allow-Origin', '*');
            $response->headers->set('Access-Control-Allow-Methods', 'GET, PUT, POST, DELETE, OPTIONS');

            return $response;
        }

        $brewery = new Brewery();

        $json = $request->getContent();
        $content = json_decode($json, true);

        $brewery->setName($content["name"]);
        $brewery->setDescription($content["description"]);
        $brewery->setWebsite($content["website"]);

        $em = $this->getDoctrine()->getManager();

        foreach ($content["beers"] as $beer_id) {
          $beer = $em->getRepository(Beer::class)->find($beer_id);
          if (!$beer) {
            throw $this->createNotFoundException(
              'No beer found for this beer id '.$beer_id
            );
          }
          else {
            $brewery->addBeer($beer);
          }
        }

        if (!$brewery) {
            return new Response("Error: brewery creation aborted !");
        }
        else {
            $em->persist($brewery);
            $em->flush();
            return new Response("The brewery has been successfully added !");
        }
    }


    /**
     * @Route("/api/breweries/update_brewery/{id}", name="api_update_brewery", methods={"PUT"}))
     */
    public function updateBreweryAction(Request $request, $id)
    {
        // just setup a fresh $task object (remove the dummy data)
        if ($_SERVER['REQUEST_METHOD'] == 'OPTIONS')
        {
            $response = new Response();
            $response->headers->set('Access-Control-Allow-Origin', '*');
            $response->headers->set('Access-Control-Allow-Methods', 'GET, PUT, POST, DELETE, OPTIONS');

            return $response;
        }

        $json = $request->getContent();
        $content = json_decode($json, true);

        $brewery = $this->getDoctrine()
            ->getRepository(Brewery::class)
            ->find($id);

        $brewery->setName($content["name"]);
        $brewery->setDescription($content["description"]);
        $brewery->setWebsite($content["website"]);

        $em = $this->getDoctrine()->getManager();

        foreach ($content["beers"] as $beer_id) {
          $beer = $em->getRepository(Beer::class)->find($beer_id);
          if (!$beer) {
            throw $this->createNotFoundException(
              'No beer found for this beer id '.$beer_id
            );
          }
          else {
            $brewery->addBeer($beer);
          }
        }

        if (!$brewery) {
            return new Response("Error: brewery update aborted !");
        }
        else {
            $em->persist($brewery);
            $em->flush();
            return new Response("The brewery has been successfully updated !");
        }
    }


    /**
     * @Route("/api/breweries/delete_brewery/{id}", name="api_delete_brewery", methods={"DELETE"}))
     */
    public function deleteBreweryAction(Request $request, $id)
    {
        // just setup a fresh $task object (remove the dummy data)
        if ($_SERVER['REQUEST_METHOD'] == 'OPTIONS')
        {
            $response = new Response();
            $response->headers->set('Access-Control-Allow-Origin', '*');
            $response->headers->set('Access-Control-Allow-Methods', 'GET, PUT, POST, DELETE, OPTIONS');

            return $response;
        }

        $entityManager = $this->getDoctrine()->getManager();
        $brewery = $entityManager->getRepository(Brewery::class)->find($id);

        if (!$brewery) {
          throw $this->createNotFoundException(
              'No brewery found for this id '.$id
            );
          }

        $entityManager->remove($brewery);
        $entityManager->flush();
        return new Response("The brewery was successfully deleted !");
    }
}
