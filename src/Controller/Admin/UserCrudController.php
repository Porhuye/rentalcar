<?php

namespace App\Controller\Admin;

use App\Entity\User;
use App\Repository\UserRepository;
use EasyCorp\Bundle\EasyAdminBundle\Config\Crud;
use EasyCorp\Bundle\EasyAdminBundle\Field\IdField;
use EasyCorp\Bundle\EasyAdminBundle\Field\TextField;
use EasyCorp\Bundle\EasyAdminBundle\Field\ImageField;
use EasyCorp\Bundle\EasyAdminBundle\Field\ChoiceField;
use EasyCorp\Bundle\EasyAdminBundle\Field\AssociationField;
use EasyCorp\Bundle\EasyAdminBundle\Controller\AbstractCrudController;

class UserCrudController extends AbstractCrudController
{
    public static function getEntityFqcn(): string
    {
        return User::class;
    }

    public function configureCrud(Crud $crud): Crud
    {
        return $crud
            ->setEntityLabelInSingular('Utilisateur')
            ->setEntityLabelInPlural('Utilisateurs');
    }

    public function configureFields(string $pageName): iterable
    {
        $required = $pageName === Crud::PAGE_INDEX;

        $association = AssociationField::new('klient_id_klienta', 'Email klienta')
            ->setFormTypeOption(
                'query_builder', function (UserRepository $userRepository) {
                    return $userRepository->createQueryBuilder('u')
                        ->andWhere('u.roles LIKE :role')->setParameter('role', '%"ROLE_USER"%');
                }
            );

        return [
            IdField::new('id')->setLabel('ID'),
            TextField::new('name')->setLabel('Nom'),
            TextField::new('email')->setLabel('Email'),

            ChoiceField::new('roles')
                ->setLabel('Rôles')
                ->allowMultipleChoices()
                ->setChoices([
                    'Utilisateur' => 'ROLE_USER',
                    'Admin' => 'ROLE_ADMIN',
                ]),

            ImageField::new('picture')
                ->setLabel('Image')
                ->setUploadDir('public/uploads/images/')
                ->setBasePath('uploads/images/')
                ->setUploadedFileNamePattern('[name]-[timestamp].[extension]')
                ->setRequired($required),
        ];
    }
}
