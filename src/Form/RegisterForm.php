<?php

namespace App\Form;

use App\Entity\Car;
use Doctrine\DBAL\Types\BooleanType;
use Symfony\Component\Form\AbstractType;
use Symfony\Component\Form\FormBuilderInterface;
use Symfony\Component\OptionsResolver\OptionsResolver;
use Symfony\Component\Form\Extension\Core\Type\DateType;
use Symfony\Component\Form\Extension\Core\Type\FileType;
use Symfony\Component\Form\Extension\Core\Type\TextType;
use Symfony\Component\Form\Extension\Core\Type\NumberType;
use Symfony\Component\Form\Extension\Core\Type\SubmitType;
use Symfony\Component\Form\Extension\Core\Type\CheckboxType;

class RegisterForm extends AbstractType
{
    public function buildForm(FormBuilderInterface $builder, array $options): void
    {
        $builder
            ->add('brand', TextType::class, [
                'label' => 'La marque ',
                'attr' => [
                    'class' => 'form-control',
                    'placeholder' => 'Entrez la marque de la voiture'
                ]
            ])

            ->add('model', TextType::class, [
                'label' => 'La model ',
                'attr' => [
                    'class' => 'form-control',
                    'placeholder' => 'Entrez le model de la voiture'
                ]
            ])
            ->add('year',NumberType::class, [
                'label' => 'L\'année de la voiture', // le " \' " sert a pouvoir mettre le crochet 
                'attr' => [
                    'class' => 'form-control',
                    'placeholder' => 'Entrez l\'année de la voiture'
                ]
            ])
            ->add('picture',FileType::class, [
                'label' => 'Photo de la voiture',
                'attr' => [
                    'class' => 'form-control',
                    'placeholder' => 'Entrez votre photo de profil'
                ],
                'required' => false,
                'mapped' => false,
            ])
            ->add('price',NumberType::class, [
                'label' => 'Le prix',
                'attr' => [
                    'class' => 'form-control',
                    'placeholder' => 'Entrez le prix'
                ],
                'required' => false
            ])
            ->add('description',TextType::class, [
                'label' => 'Description',
                'attr' => [
                    'class' => 'form-control',
                    'placeholder' => 'Ajouter une description'
                ],
                'required' => false
            ])
            ->add('available',CheckboxType::class, [
                'label'    => 'Voiture disponible ?',
                'required' => false,
                
            ])
            ->add('likes',NumberType::class, [
                'label' => 'Nombre de likes',
                'attr' => [
                    'class' => 'form-control',
                    'placeholder' => 'Entrez votre le nombre de likes'
                ],
                'required' => false
            ])
            ->add('valider',SubmitType::class, [
                'label' => 'Valider',
                'attr' => [
                    'class' => 'btn btn-primary mt-2'
                ]
            ])
        ;
    }

    public function configureOptions(OptionsResolver $resolver): void
    {
        $resolver->setDefaults([
            'data_class' => Car::class,
        ]);
    }
}
