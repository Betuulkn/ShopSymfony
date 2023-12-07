<?php

namespace App\Controller;

use App\Entity\User;
use App\Form\RegistrationFormType;
use App\Form\UserType; 
use Doctrine\ORM\EntityManagerInterface;
use Symfony\Bundle\FrameworkBundle\Controller\AbstractController;
use Symfony\Component\HttpFoundation\Request;
use Symfony\Component\HttpFoundation\Response;
use Symfony\Component\PasswordHasher\Hasher\UserPasswordHasherInterface;
use Symfony\Component\Routing\Annotation\Route;

#[Route('/profil')]
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
    public function profile(EntityManagerInterface $em, Request $request, UserPasswordHasherInterface $passwordHasher): Response
    {
        // Get the user logged-in
        $user = $this->getUser();

        // Form to update the user information
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

            $em->persist($user); 
            $em->flush(); 
            $this->addFlash('success', 'Informations modifiées !');
        }

        return $this->render('profile/profile.html.twig', [
            'user' => $user,
            'updateInfosUser' => $form->createView(), 
        ]);
    }

    #[Route('/orders', name: 'app_orders')]
    public function orders(): Response
    {
        //$orders = ; 

        return $this->render('profile/orders.html.twig', [
            //'orders' => $orders,
        ]);
    }
}
