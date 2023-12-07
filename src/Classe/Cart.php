<?php

namespace App\Classe;

use App\Repository\ProduitRepository;
use Symfony\Component\HttpFoundation\RequestStack;

class Cart
{
    private RequestStack $requestStack;

    public function __construct(RequestStack $requestStack)
    {
        $this->requestStack = $requestStack;
    }

    /**
     * Stock the product & quantity in an array 
     * 
     * @param ProduitRepository
     * @return array 
     */
    public function getFull(ProduitRepository $produitRepository): ?array
    {
        $completeCart = [];

        if($this->get()) {
            foreach($this->get() as $id => $quantite) {

                $produit_object = $produitRepository->find($id);
                // if the produit id doesn't exist, delete the produit id from the cart
                if(!$produit_object) {
                    $this->delete($id);
                    continue; // don't return this
                }

                $completeCart[] = [
                    "produit" =>  $produit_object,
                    "quantite" => $quantite
                ];
            }
        }
        return $completeCart;
    }

    /**
     * Add quantity or one product
     *
     * @param $id
     * @return mixed
     */
    public function add($id)
    {
        $session = $this->requestStack->getSession();
        $cart = $session->get('cart', []);

        if(!empty($cart[$id])) {
            $cart[$id]++;
        } else {
            $cart[$id] = 1;
        }

        return $session->set('cart', $cart);
    }

    /**
     * Decrease quantity or remove a product
     *
     * @param $id
     * @return mixed
     */
    public function decrease($id)
    {
        $session = $this->requestStack->getSession();
        $cart = $session->get('cart', []);

        if($cart[$id] > 1) {
            $cart[$id]--;
        } else {
            unset($cart[$id]);
        }

        return $session->set('cart', $cart);
    }

    /**
     * Get
     *
     * @return mixed
     */
    public function get(): mixed
    {
        $session = $this->requestStack->getSession();

        return $session->get('cart');
    }

    /**
     * Remove
     *
     * @return mixed
     */
    public function remove(): mixed
    {
        $session = $this->requestStack->getSession();

        return $session->remove('cart');
    }

    public function delete($id)
    {
        $session = $this->requestStack->getSession();
        $cart = $session->get('cart', []);
        unset($cart[$id]);

        return $session->set('cart', $cart);
    }
}