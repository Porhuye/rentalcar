<?php

namespace App\Controller\Admin;

use App\Entity\User;
use EasyCorp\Bundle\EasyAdminBundle\Config\Crud;
use EasyCorp\Bundle\EasyAdminBundle\Field\IdField;
use EasyCorp\Bundle\EasyAdminBundle\Field\TextField;
use EasyCorp\Bundle\EasyAdminBundle\Field\TextEditorField;
use EasyCorp\Bundle\EasyAdminBundle\Controller\AbstractCrudController;

class UserCrudController extends AbstractCrudController
{
    public static function getEntityFqcn(): string
    {
        return User::class;
    }

    public function configureCrud(Crud $crud): Crud {
        
        return $crud
        ->setEntityLabelinSingular('Utilisateur')
        ->setEntityLabelinPlural('Utilisateurs');
    }
    
    public function configureFields(string $pageName): iterable
    {
        return [
            TextField::new('name')-> setLabel('Nom'),
            TextField::new('email')-> setLabel('Email'),
            TextField::new('roles')-> setLabel('Role'),
            TextField::new('picture')-> setLabel('Photo de profil')
        ];
    }
    
}
