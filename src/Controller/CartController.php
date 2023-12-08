<?php

namespace App\Controller;

use App\Classe\Cart;
use App\Entity\ContenuPanier;
use App\Form\ContenuPanierType;
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
        //dd($request); 
        $contenuPanier = new ContenuPanier();
        $dateAjout = new \DateTime();
        $contenuPanier->setDateAjout($dateAjout);

        $form = $this->createForm(ContenuPanierType::class, $contenuPanier); 
        $form->handleRequest($request); 
        if ($form->isSubmitted() && $form->isValid()) {
            
            $contenuPanier = $form->getData();
           // dd($contenuPanier); 
            //$em->persist($contenuPanier); 
            //$em->flush(); 
            $this->addFlash('success', 'Panier enregistré !');
        }

        return $this->render('cart/cart.html.twig', [
            'cart' => $cart->getFull($produitRepository),
            'form' => $form->createView(),
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
