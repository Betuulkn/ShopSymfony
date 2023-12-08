<?php

namespace App\Controller;

use App\Classe\Cart;
use App\Entity\ContenuPanier;
use App\Entity\Panier;
use App\Repository\ProduitRepository;
use Doctrine\ORM\EntityManagerInterface;
use Symfony\Bundle\FrameworkBundle\Controller\AbstractController;
use Symfony\Component\HttpFoundation\Request;
use Symfony\Component\HttpFoundation\Response;
use Symfony\Component\Routing\Annotation\Route;

#[Route('/panier')]
class CartController extends AbstractController
{
    /**
     * Cart 
     * @param Cart $cart
     * @param ProduitRepository $produitRepository
     * @return Response
     */
    #[Route('/', name: 'app_cart')]
    public function cart(Cart $cart, ProduitRepository $produitRepository, Request $request, EntityManagerInterface $em): Response
    {
        // Form to save the cart in the database 
        if (isset($_POST['submitCart']) && !empty($_POST['submitCart'])) {
           //dd($_POST['produitId']); 

           $user = $this->getUser(); 
           $panier = new Panier();
           $dateAchat = new \DateTime();
           $panier->setDateAchat($dateAchat);
           $panier->setEtat(true); 
           $panier->setUser($user); 
           // Save the panier in the database
           $em->persist($panier); 
           $em->flush(); 
   
           $panierRepo = $em->getRepository(Panier::class); 
           $lastPanier = $panierRepo->findOneBy([], ['id' => 'DESC']);
           $produit = $produitRepository->findOneBy(array('id'=> $_POST['produitId']));

           $contenuPanier = new ContenuPanier(); 
           $contenuPanier->setPanier($lastPanier); 
           $contenuPanier->addProduit($produit); 
           $contenuPanier->setQuantite($_POST['produitQuantite']); 
           $contenuPanier->setDateAjout($dateAchat); 
           // Save the contenuPanier in the database
           $em->persist($contenuPanier); 
           $em->flush(); 
        }

        return $this->render('cart/cart.html.twig', [
            'cart' => $cart->getFull($produitRepository),
        ]);
    }

     /**
     * Add product in the cart
     *
     * @param Cart $cart
     * @param $id
     * @return Response
     */
    #[Route('/add/{id}', name: 'app_add_to_cart')]
    public function add(Cart $cart, $id): Response
    {
        $cart->add($id);
        //dd($cart->get());

        return $this->redirectToRoute('app_cart');
    }

    /**
     * Decrease the quantiy 
     */
    #[Route('/decrease/{id}', name: 'app_decrease_to_cart')]
    public function decrease(Cart $cart, $id): Response
    {
        $cart->decrease($id);
        //dd($cart->get());

        return $this->redirectToRoute('app_cart');
    }

     /**
     * Remove the cart
     *
     * @param Cart $cart
     * @return Response
     */
    #[Route('/remove', name: 'app_remove_cart')]
    public function remove(Cart $cart): Response
    {
        $cart->remove();

        return $this->redirectToRoute('app_home');
    }

    /**
     * Remove the product in the cart
     */
    #[Route('/delete/{id}', name: 'app_delete_to_cart')]
    public function delete(Cart $cart, $id): Response
    {
        $cart->delete($id);

        return $this->redirectToRoute('app_cart');
    }
}
