<?php

namespace App\Controller;

use App\Entity\ContenuPanier;
use App\Entity\User;
use App\Form\RegistrationFormType;
use App\Form\UserType;
use App\Repository\ContenuPanierRepository;
use Doctrine\ORM\EntityManagerInterface;
use Symfony\Bundle\FrameworkBundle\Controller\AbstractController;
use Symfony\Component\HttpFoundation\Request;
use Symfony\Component\HttpFoundation\Response;
use Symfony\Component\PasswordHasher\Hasher\UserPasswordHasherInterface;
use Symfony\Component\Routing\Annotation\Route;

#[Route('/{_locale}/profil')]
class ProfileController extends AbstractController
{
    /**
     * User profile : display information & update form
     * 
     * @param EntityManagerInterface 
     * @param Request
     * @param UserPasswordHasherInterface
     * @return Response
     */
    #[Route('/', name: 'app_profile')]
    public function profile(EntityManagerInterface $em, Request $request,  UserPasswordHasherInterface $passwordHasher): Response
    {
        // Get the user logged-in
        $user = $this->getUser();

        // Form to update the user informations
        $form = $this->createForm(UserType::class, $user); 
        $form->handleRequest($request); 
        if ($form->isSubmitted() && $form->isValid()) {
            $user = $form->getData();
            // Hash the password
            $hashedPassword = $passwordHasher->hashPassword(
                $user, 
                $user->getPassword()
            );
            $user->setPassword($hashedPassword);
            // Save the updatings in the database 
            $em->persist($user); 
            $em->flush(); 
            $this->addFlash('success', 'Informations modifiées !');
        }

        return $this->render('profile/profile.html.twig', [
            'user' => $user,
            'updateInfosUser' => $form->createView(), 
        ]);
    }

    /**
     * Display all the orders 
     * 
     * @return Response
     */
    #[Route('/commandes', name: 'app_orders')]
    public function orders(ContenuPanierRepository $contenuPanierRepository): Response
    {
        $orders = $contenuPanierRepository->findAll();

        return $this->render('profile/orders.html.twig', [
            'orders' => $orders,
        ]);
    }

    /**
     * Display one order 
     * 
     * @return Response
     */
    #[Route('/commandes/{id}', name: 'app_order')]
    public function order(ContenuPanier $contenuPanier): Response
    { 
        return $this->render('profile/order.html.twig', [
            'order' => $contenuPanier,
        ]);
    }
}
