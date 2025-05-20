<?php

namespace App\Controller\Admin;

use App\Entity\Car;
use EasyCorp\Bundle\EasyAdminBundle\Config\Crud;
use EasyCorp\Bundle\EasyAdminBundle\Field\IdField;
use EasyCorp\Bundle\EasyAdminBundle\Field\TextField;
use EasyCorp\Bundle\EasyAdminBundle\Config\Dashboard;
use EasyCorp\Bundle\EasyAdminBundle\Field\TextEditorField;
use EasyCorp\Bundle\EasyAdminBundle\Controller\AbstractCrudController;

class CarCrudController extends AbstractCrudController
{
    public static function getEntityFqcn(): string
    {
        return Car::class;
    }

    public function configureCrud(Crud $crud): Crud {
        
        return $crud
        ->setEntityLabelinSingular('Voiture')
        ->setEntityLabelinPlural('Voitures');
    }
    
    public function configureFields(string $pageName): iterable
    {
        return [
            TextField::new('firstname')-> setLabel('Prénom'),
            TextField::new('lastname')-> setLabel('Nom'),
            TextField::new('email')-> setLabel('Email'),
            TextField::new('picture')-> setLabel('Photo de profil')
        ];
    }
    
}
