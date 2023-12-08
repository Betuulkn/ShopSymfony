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
use Symfony\Contracts\Translation\TranslatorInterface;

class HomeController extends AbstractController
{
    /**
     * Home : Display all the products & has a add form for the admin 
     * 
     * @param Request
     * @param EntityManagerInterface
     * @return Response|
     * 
     */
    #[Route('/{_locale}/', name: 'app_home')]
    public function home(TranslatorInterface $translator, 
    Request $request, EntityManagerInterface $em): Response
    {
        // Create an Admin 
        if ($this->getUser()) {
            $user = $this->getUser(); 
            //dd($user->getEmail()); 
            if ($user->getEmail() == "julien@gmail.com") {
                $user->setRoles(['ROLE_ADMIN']); 
            }
        }

        

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
