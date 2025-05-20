<?php

namespace App\Controller\Admin;

use App\Entity\Car;
use EasyCorp\Bundle\EasyAdminBundle\Config\Crud;
use EasyCorp\Bundle\EasyAdminBundle\Field\IdField;
use EasyCorp\Bundle\EasyAdminBundle\Field\TextField;
use EasyCorp\Bundle\EasyAdminBundle\Config\Dashboard;
use EasyCorp\Bundle\EasyAdminBundle\Field\ImageField;
use EasyCorp\Bundle\EasyAdminBundle\Field\NumberField;
use EasyCorp\Bundle\EasyAdminBundle\Field\TextEditorField;
use EasyCorp\Bundle\EasyAdminBundle\Controller\AbstractCrudController;

class CarCrudController extends AbstractCrudController
{
    public static function getEntityFqcn(): string
    {
        return Car::class;
    }

    public function configureCrud(Crud $crud): Crud
    {

        return $crud
            ->setEntityLabelinSingular('Voiture')
            ->setEntityLabelinPlural('Voitures');
    }

    public function configureFields(string $pageName): iterable
    {

        $required = false;

        if ($pageName === Crud::PAGE_INDEX) {
            $required = true;
        }

        return [
            TextField::new('brand')->setLabel('Marque'),
            TextField::new('model')->setLabel('Model'),
            TextField::new('year')->setLabel('Année'),
            ImageField::new('picture')
                ->setLabel('Image')
                ///ATTENTION il faut créer les dossiers nous même !\\\\
                ->setUploadDir('public/uploads/images/') // chemin pour upload l'image
                ->setBasePath('uploads/images/') //chemin pour afficher img
                ->setUploadedFileNamePattern('[name]-[timestamp].[extension]') // sert a ajouter le temps pour éviter les doublons -> en gros sert a le rendre unique 
                ->setRequired($required),
            NumberField::new('price')->setLabel('Prix'),
            TextEditorField::new('description')->setLabel('Description'),
            NumberField::new('available')->setLabel('Disponible ?'),
            NumberField::new('likes')->setLabel('J\'aime'),


        ];
    }
}
