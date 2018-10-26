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
        $beers = $em->getRepository(Beer::class)->findAll();
        $jsonContent = $serializer->serialize($beers,'json');
        $response = new JsonResponse();
        $response->setContent($jsonContent);
        return $response;
    }


    /**
     * @Route("/api/beers/add_beer", name="api_add_beer", methods={"POST"}))
     */
    public function addBeerAction(Request $request)
    {
        // just setup a fresh $task object (remove the dummy data)
        if ($_SERVER['REQUEST_METHOD'] == 'OPTIONS')
        {
            $response = new Response();
            $response->headers->set('Access-Control-Allow-Origin', '*');
            $response->headers->set('Access-Control-Allow-Methods', 'GET, PUT, POST, DELETE, OPTIONS');

            return $response;
        }

        $beer = new Beer();
        $type = new Type();
        $brewery = new Brewery();

        $json = $request->getContent();
        $content = json_decode($json, true);

        $beer->setName($content["name"]);
        $beer->setDescription($content["description"]);
        $beer->setVolume($content["volume"]);

        $type = $this->getDoctrine()
            ->getRepository(Type::class)
            ->find($content['id_type']);

        if (!$type) {
          throw $this->createNotFoundException(
            'No type found for this type id '.$content['id_type']
            );
        }
        $beer->setType($type);

        $brewery = $this->getDoctrine()
            ->getRepository(Brewery::class)
            ->find($content['id_brewery']);
        if (!$brewery) {
          throw $this->createNotFoundException(
            'No type found for this brewery id '.$content['id_brewery']
            );
        }

        if (!$beer) {
            return new Response("Error: beer creation aborted !");
        }
        else {
            $em = $this->getDoctrine()->getManager();
            $em->persist($beer);
            $em->flush();
            return new Response("The beer was successfully added !");
        }
    }


    /**
     * @Route("/api/beers/update_beer/{id}", name="api_update_beer", methods={"PUT"}))
     */
    public function updateBeerAction(Request $request, $id)
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
        $beer = $entityManager->getRepository(Beer::class)->find($id);

        if (!$beer) {
          throw $this->createNotFoundException(
            'No beer found for this id '.$id
          );
        }
    }


    /**
     * @Route("/api/beers/delete_beer/{id}", name="api_delete_beer", methods={"DELETE"}))
     */
    public function deleteBeerAction(Request $request, $id)
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
        $beer = $entityManager->getRepository(Beer::class)->find($id);

        if (!$beer) {
          throw $this->createNotFoundException(
              'No beer found for this id '.$id
            );
          }

        $entityManager->remove($beer);
        $entityManager->flush();
        return new Response("The beer was successfully deleted !");
    }
}
