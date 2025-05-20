<?php

namespace App\Controller;

use App\Entity\Car;
use App\Form\RegisterForm;
use Doctrine\ORM\EntityManagerInterface;
use Symfony\Component\HttpFoundation\Request;
use Symfony\Component\HttpFoundation\Response;
use Symfony\Component\Routing\Attribute\Route;
use Symfony\Component\String\Slugger\SluggerInterface;
use Symfony\Bundle\FrameworkBundle\Controller\AbstractController;
use Symfony\Component\HttpFoundation\File\Exception\FileException;
use Symfony\Component\PasswordHasher\Hasher\UserPasswordHasherInterface;
use Symfony\Component\DependencyInjection\Attribute\Autowire;

final class CarController extends AbstractController
{
    #[Route('/car/register', name: 'app_car_register')]
    public function index(
        Request $request,
        EntityManagerInterface $em,
        SluggerInterface $slugger,
        #[Autowire('%kernel.project_dir%/public/uploads/images')] string $brochuresDirectory
    ): Response {
        $car  = new Car();
        $form = $this->createForm(RegisterForm::class, $car);
        $form->handleRequest($request);

        if ($form->isSubmitted() && $form->isValid()) {
            //dd($form->getData()); //dump and die = vardumb
            //dd($newcar);
            $brochureFile = $form->get('picture')->getData();

            // this condition is needed because the 'brochure' field is not required
            // so the PDF file must be processed only when a file is uploaded
            if ($brochureFile) {
                $originalFilename = pathinfo($brochureFile->getClientOriginalName(), PATHINFO_FILENAME);
                // this is needed to safely include the file name as part of the URL
                $safeFilename = $slugger->slug($originalFilename);
                $newFilename = $safeFilename . '-' . uniqid() . '.' . $brochureFile->guessExtension();

                // Move the file to the directory where brochures are stored
                try {
                    $brochureFile->move($brochuresDirectory, $newFilename);
                } catch (FileException $e) {
                    // ... handle exception if something happens during file upload
                }

                // updates the 'picture' property to store the PDF file name
                // instead of its contents
                $car->setPicture($newFilename);
            }

            $em->persist($car);
            $em->flush();
        }
        return $this->render('car/new.index.html.twig', [
            'form' => $form->createView(), // sert a créer une vue pour le formulaire 
            'car' => $car,
        ]);
    }

    #[Route('/car/{id}', name: 'app_car_single')]
    public function singlecar($id, EntityManagerInterface $em): Response
    {
        $car =  $em->getRepository(Car::class)->findBy(['id' => $id])[0]; // recup produit par ID

        return $this->render('car/single.html.twig', [
            'car' => $car,
        ]);
        /*
        return $this->render('car_register/index.html.twig', [
            'form' => $form->createView(),
            'car' => $car,
        ]);
        */
    }

    #[Route('/car/suppr/{id}', name: 'app_car_suppr')]
    public function supprcar($id, Request $request, EntityManagerInterface $em): Response // pas sur du request
    {
        $car =  $em->getRepository(car::class)->findBy(['id' => $id])[0]; // recup produit par ID

        $em->remove($car);
        $em->flush();

        return $this->redirectToRoute('app_home'); // redirige a l'acueil
    }

    #[Route('/car/edit/{id}', name: 'app_car_edit')]
    public function editcar($id, Request $request, EntityManagerInterface $em): Response
    {
        $car =  $em->getRepository(car::class)->findBy(['id' => $id])[0]; // recup produit par ID
        //$newcar = new car(); //création d'un nouveau object car
        $form = $this->createForm(RegisterForm::class, $car); // créer un formulaire par rapport au modèle précédamment créer
        $form->handleRequest($request); //on gere les requete

        if ($form->isSubmitted() && $form->isValid()) {
            $em->persist($car);
            $em->flush();
            return $this->redirectToRoute('app_car_single', ['id' => $car->getId()]);
        }


        return $this->render('car/edit.html.twig', [
            'car' => $car,
            'form' => $form->createView(), // sert a créer une vue pour le formulaire
        ]);
    }
}
