<?php

namespace App\Controller;

use App\Entity\Produit;
use App\Form\ProduitType;
use Doctrine\ORM\EntityManagerInterface;
use Symfony\Bundle\FrameworkBundle\Controller\AbstractController;
use Symfony\Component\HttpFoundation\File\Exception\FileException;
use Symfony\Component\HttpFoundation\Request;
use Symfony\Component\HttpFoundation\Response;
use Symfony\Component\Routing\Annotation\Route;

class HomeController extends AbstractController
{
    /**
     * Home : Display all the products & has a add form for the admin 
     */
    #[Route('/{_locale<en|fr>}', name: 'app_home')]
    public function home(Request $request, EntityManagerInterface $em): Response
    {
        $produit= new Produit();
        $form = $this->createForm(ProduitType::class, $produit); 
        $form->handleRequest($request); 
        if ($form->isSubmitted() && $form->isValid()) {
            // Download the photo 
            $imageFile = $form->get('photo')->getData();
            if ($imageFile) {
                $newFilename = uniqid().'.'.$imageFile->guessExtension();
                // Move the file to the directory where images are stored
                try {
                    $imageFile->move(
                        $this->getParameter('upload_directory'),
                        $newFilename
                    );
                } catch (FileException $e) {
                    $this->addFlash('danger', 'Impossible d\'ajouter la photo.'); 
                }
                $produit->setPhoto($newFilename);
            }

            $em->persist($produit); 
            $em->flush(); 
            $this->addFlash('success', 'Produit ajouté !');
        }

        $produits = $em->getRepository(Produit::class)->findAll(); 

        return $this->render('home/home.html.twig', [
            'produits' => $produits,
            'ajout' => $form->createView(),
        ]);
    }
}
