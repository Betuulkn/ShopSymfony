<?php

namespace App\Controller;

use App\Entity\Produit;
use App\Repository\ProduitRepository;
use App\Form\ProduitType;
use Doctrine\ORM\EntityManagerInterface;
use Symfony\Bundle\FrameworkBundle\Controller\AbstractController;
use Symfony\Component\HttpFoundation\Request;
use Symfony\Component\HttpFoundation\Response;
use Symfony\Component\Routing\Annotation\Route;

#[Route('/produit')]
class ProduitController extends AbstractController
{
    #[Route('/{id}', name: 'app_produit')]
    public function category(EntityManagerInterface $em, ProduitRepository $produitRepository, Produit $produit = null,  Request $request): Response
    {
        if ($produit == null) { 
            $this->addFlash('danger','Produit introuvable !');
            return $this->redirectToRoute('app_home'); 
        } 
 
        $form = $this->createForm(ProduitType::class, $produit); 
        
        $form->handleRequest($request); 
        if ($form->isSubmitted() && $form->isValid()) {
            $em->persist($produit); 
            $em->flush(); 

            $this->addFlash('success','Produit modifié !');
        }
  
        return $this->render('produit/show.html.twig', [
            'produit' => $produit, 
            'modification' => $form->createView(),
        ]);
    }
}
