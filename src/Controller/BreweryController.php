<?php

namespace App\Controller;

use Symfony\Bundle\FrameworkBundle\Controller\AbstractController;
use Symfony\Component\Routing\Annotation\Route;

class BreweryController extends AbstractController
{
    /**
     * @Route("/breweries", name="breweries")
     */
    public function indexAction()
    {
        return $this->render('brewery/index.html.twig', [
            'controller_name' => 'BreweryController',
        ]);
    }
}
