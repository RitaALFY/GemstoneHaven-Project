<?php

namespace App\Form;

use App\Entity\Address;
use App\Entity\User;
use App\Repository\AddressRepository;
use Symfony\Bridge\Doctrine\Form\Type\EntityType;
use Symfony\Component\Form\AbstractType;
use Symfony\Component\Form\Extension\Core\Type\ChoiceType;
use Symfony\Component\Form\Extension\Core\Type\DateType;
use Symfony\Component\Form\Extension\Core\Type\EmailType;
use Symfony\Component\Form\Extension\Core\Type\FileType;
use Symfony\Component\Form\Extension\Core\Type\PasswordType;
use Symfony\Component\Form\FormBuilderInterface;
use Symfony\Component\OptionsResolver\OptionsResolver;
use Symfony\Component\Validator\Constraints\File;

class UserType extends AbstractType
{
    public function buildForm(FormBuilderInterface $builder, array $options): void
    {
        $builder
            ->add('email', EmailType::class, [
                'label' => 'Email',
            ])
            ->add('password', PasswordType::class, [
                'label' => 'Mot de passe'
            ])
            ->add('firstName', null, [
                'label' => 'Prénom'
            ])
            ->add('lastName', null, [
                'label' => 'Nom'
            ])
            ->add('gender', ChoiceType::class, [
                'label' => 'Genre',
                'choices' => [
                    'Femme' => 'F',
                    'Homme' => 'M',
                ],
                'expanded' => true, // Affiche des boutons radio au lieu d'une liste déroulante
                'multiple' => false, // Un seul choix possible
            ])
            ->add('birthAt', DateType::class, [
                'widget' => 'single_text',
                'label' => 'Date de naissance',])
            ->add('image', FileType::class, [
                'label' => 'Photo de profile',
                'required' => false,
                'mapped' => false, // => Dit à Symfony : t'inquiètes, je le gère moi-même
                'constraints' => [
                    new File(
                        maxSize: '3M',
                        mimeTypes: ['image/png', 'image/jpeg'],
                        maxSizeMessage: 'Ton fichier est trop lourd !',
                        mimeTypesMessage: 'Déposer seulement un .jpg ou .png'
                    )
                ]
            ])
            ->add('address',EntityType::class, [
                'label' => 'Pays',
                'class' => Address::class,
                'choice_label' => 'country',
                'query_builder' => function (AddressRepository $ad) {
                    return $ad->createQueryBuilder('c')
                        ->orderBy('c.country', 'ASC');
                }
            ])
        ;
    }
    public function configureOptions(OptionsResolver $resolver): void
    {
        $resolver->setDefaults([
            'data_class' => User::class,
        ]);
    }
}
