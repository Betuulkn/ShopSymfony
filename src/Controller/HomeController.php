<?php

namespace App\Controller;

use App\Entity\Produit;
use Doctrine\ORM\EntityManagerInterface;
use Symfony\Bundle\FrameworkBundle\Controller\AbstractController;
use Symfony\Component\HttpFoundation\Request;
use Symfony\Component\HttpFoundation\Response;
use Symfony\Component\Routing\Annotation\Route;

class HomeController extends AbstractController
{
    #[Route('/', name: 'app_home')]
    public function home(Request $request, EntityManagerInterface $em): Response
    {
        $produit = new Produit();
        
        
      

        return $this->render('home/home.html.twig', [
            'controller_name' => 'HomeController',
        ]);
    }
}
