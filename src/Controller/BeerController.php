<?php

namespace App\Controller;

use Symfony\Bundle\FrameworkBundle\Controller\AbstractController;
use Symfony\Component\Routing\Annotation\Route;

class BeerController extends AbstractController
{
    /**
     * @Route("/beers", name="beers")
     */
    public function indexAction()
    {
        return $this->render('beer/index.html.twig', [
            'controller_name' => 'BeerController',
        ]);
    }
}
