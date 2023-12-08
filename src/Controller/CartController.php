<?php

namespace App\Controller;

use App\Classe\Cart;
use App\Entity\ContenuPanier;
use App\Entity\Panier;
use App\Repository\PanierRepository;
use App\Repository\ProduitRepository;
use Doctrine\ORM\EntityManagerInterface;
use Symfony\Bundle\FrameworkBundle\Controller\AbstractController;
use Symfony\Component\HttpFoundation\Request;
use Symfony\Component\HttpFoundation\Response;
use Symfony\Component\Routing\Annotation\Route;

#[Route('/{_locale}/panier')]
class CartController extends AbstractController
{
    /**
     * Cart 
     * @param Cart $cart
     * @param ProduitRepository $produitRepository
     * @return Response
     */
    #[Route('/', name: 'app_cart')]
    public function cart(Cart $cart, ProduitRepository $produitRepository, PanierRepository $panierRepository, EntityManagerInterface $em): Response
    {
        // Form to save the cart in the database 
        if (isset($_POST['submitCart']) && !empty($_POST['submitCart'])) {
            // Get data from the form 
            $form = $_POST['form'];
            $dateAchat = new \DateTime();
            $userLogged = $this->getUser(); 
            $panier = $panierRepository->findOneByUser($userLogged->getId());

            // Check if the panier already exists for the user logged in 
            if ($panier != null && $panier->isEtat() == 0) {
                $panier = $panier;
            } else {
                $panier = new Panier();
                $panier->setDateAchat($dateAchat);
                $panier->setEtat(true); 
                $panier->setUser($userLogged); 
                $em->persist($panier);
            } 
         
            foreach ($form as $key => $value) {
                $produit = $produitRepository->findOneBy(array('id'=> $value['produitId']));
                $contenuPanier = new ContenuPanier(); 
                $contenuPanier->setPanier($panier); 
                $contenuPanier->setQuantite($value['produitQte']); 
                $contenuPanier->setDateAjout($dateAchat); 
                $contenuPanier->setProduit($produit); 

                $em->persist($contenuPanier);
            }
            
            $em->flush();
            $this->addFlash('success', 'Panier acheté !');
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

        return $this->redirectToRoute('app_cart');
    }

    /**
     * Decrease the quantiy 
     */
    #[Route('/decrease/{id}', name: 'app_decrease_to_cart')]
    public function decrease(Cart $cart, $id): Response
    {
        $cart->decrease($id);

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
