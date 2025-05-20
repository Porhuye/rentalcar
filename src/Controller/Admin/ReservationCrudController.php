<?php

namespace App\Controller\Admin;

use App\Entity\Reservation;
use EasyCorp\Bundle\EasyAdminBundle\Config\Crud;
use Symfony\Component\Validator\Constraints\Date;
use EasyCorp\Bundle\EasyAdminBundle\Field\IdField;
use EasyCorp\Bundle\EasyAdminBundle\Field\DateField;
use EasyCorp\Bundle\EasyAdminBundle\Field\TextField;
use EasyCorp\Bundle\EasyAdminBundle\Field\TextEditorField;
use EasyCorp\Bundle\EasyAdminBundle\Controller\AbstractCrudController;

class ReservationCrudController extends AbstractCrudController
{
    public static function getEntityFqcn(): string
    {
        return Reservation::class;
    }

    public function configureCrud(Crud $crud): Crud {
        
        return $crud
        ->setEntityLabelinSingular('Réservation')
        ->setEntityLabelinPlural('Réservations');
    }

    
    public function configureFields(string $pageName): iterable
    {
        return [
            DateField::new('reservedFrom')-> setLabel('Réservé du')
                ->setFormat('dd/MM/yyyy')
                ->setRequired(true),
            DateField::new('reservedTo')-> setLabel('Réservé au')
                ->setFormat('dd/MM/yyyy')
                ->setRequired(true),
            TextField::new('customerName')-> setLabel('Nom du client')
                ->setRequired(true),
            TextField::new('customerEmail')-> setLabel('Email du client')
                ->setRequired(true),
                TextField::new('customerEmail')-> setLabel('Email du client')
                ->setRequired(true),
        ];
    }
    
}
