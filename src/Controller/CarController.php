<?php

namespace App\Controller;

use App\Entity\Car;
use Doctrine\ORM\EntityManagerInterface;
use Symfony\Component\HttpFoundation\Response;
use Symfony\Component\Routing\Attribute\Route;
use Symfony\Bundle\FrameworkBundle\Controller\AbstractController;

final class CarController extends AbstractController
{
    #[Route('/car', name: 'app_car')]
    public function index(EntityManagerInterface $em): Response
    {
        $car = $em->getRepository(Car::class)->findAll(); // On recupere toutes les voitures de la base de données

        // dd($products); // On affiche les produits dans la console

        return $this->render('car/index.html.twig', [
            'cars' => $car,
        ]);
    }
}
