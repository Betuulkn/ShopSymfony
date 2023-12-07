<?php

namespace App\Controller;

use App\Entity\Panier;
use App\Repository\PanierRepository;
use App\Form\PanierType;
use Doctrine\ORM\EntityManagerInterface;
use Symfony\Bundle\FrameworkBundle\Controller\AbstractController;
use Symfony\Component\HttpFoundation\Response;
use Symfony\Component\Routing\Annotation\Route;
use Symfony\Component\HttpFoundation\Request;

class PanierController extends AbstractController
{
    #[Route('/panier', name: 'app_panier')]
    public function category(EntityManagerInterface $em, PanierRepository $panierRepository, panier $panier = null,  Request $request): Response
    {
        $panier = new Panier();
        $form = $this->createForm(PanierType::class, $panier);

        if ($panier == null) { 
            $this->addFlash('danger','Le panier est vide');
            return $this->redirectToRoute('app_panier'); 

            $form = $this->createForm(ProduitType::class, $produit); 
            $form->handleRequest($request);
                   
    
                $em->persist($panier); 
                $em->flush(); 
                $this->addFlash('success','Produit ajouté au panier');
            }
            {
            return $this->render('panier/index.html.twig', [
                'panier' => $panier, 
                'modification' => $form->createView(),
            ]);}

        }
    }

 
        

