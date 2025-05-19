<?php

namespace App\Controller;

use App\Entity\User;
use App\Form\UserForm;
use Doctrine\ORM\EntityManagerInterface;
use Symfony\Component\HttpFoundation\Request;
use Symfony\Component\HttpFoundation\Response;
use Symfony\Component\Routing\Attribute\Route;
use Symfony\Bundle\FrameworkBundle\Controller\AbstractController;
use Symfony\Component\PasswordHasher\Hasher\UserPasswordHasherInterface;

final class RegisterController extends AbstractController
{
    #[Route('/register', name: 'app_register')]
    public function index(Request $request, EntityManagerInterface $em, UserPasswordHasherInterface $ps): Response
    {

        $user  = new User();
        $form = $this->createForm(UserForm::class, $user);
        $form->handleRequest($request);

        if ($form->isSubmitted() && $form->isValid()) {
            $plainPassword = $form->get('plainPassword')->getData(); // Recupere le mot de passe en clair

            $passwordHash = $ps->hashPassword($user, $plainPassword); // Hash le mot de passe


            $user->setPassword($passwordHash); // Set le mot de passe hashé dans l'utilisateur

            $em->persist($user); // Persist l'utilisateur dans la base de données
            $em->flush(); // Flush les changements (envoi en bdd)
        }

        return $this->render('register/index.html.twig', [
            'form' => $form->createView(),
        ]);
    }
}
