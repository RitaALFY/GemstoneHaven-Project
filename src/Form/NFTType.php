<?php

namespace App\Form;

use App\Entity\Category;
use App\Entity\NFT;
use App\Entity\SubCategory;
use App\Repository\CategoryRepository;
use App\Repository\SubCategoryRepository;
use Symfony\Bridge\Doctrine\Form\Type\EntityType;
use Symfony\Component\Form\AbstractType;
use Symfony\Component\Form\Extension\Core\Type\DateType;
use Symfony\Component\Form\Extension\Core\Type\FileType;
use Symfony\Component\Form\Extension\Core\Type\TextType;
use Symfony\Component\Form\FormBuilderInterface;
use Symfony\Component\Form\FormError;
use Symfony\Component\Form\FormEvent;
use Symfony\Component\Form\FormEvents;
use Symfony\Component\OptionsResolver\OptionsResolver;
use Symfony\Component\Validator\Constraints\File;

class NFTType extends AbstractType
{
    public function buildForm(FormBuilderInterface $builder, array $options): void
    {
        $builder
            ->add('name', null,[
                'label' => 'form.nft.name.label',
            ])
            ->add('image', FileType::class, [
                'label' => 'image',
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
            ->add('dropAt', DateType::class,[
                'label' => 'form.nft.dropAt.label',
                'widget' => 'single_text',
            ])
            ->add('description', null, [
                'label' => 'form.nft.description.label'
            ])
            ->add('availableQuantity', null,[
                'label' => 'form.nft.availableQuantity.label'
            ])
            ->add('currentValue', null,[
                'label' => 'form.nft.currentValue.label'
            ])

            ->add('subCategory', EntityType::class,[
                'label' => 'form.nft.subCategory.label',
                'class' => SubCategory::class,
                'choice_label' => 'name',

                'query_builder' => function (SubCategoryRepository $sub) {
                    return $sub->createQueryBuilder('sub')
                        ->orderBy('sub.name', 'ASC');
                },



            ])
            ->add('selectedCategoryName', TextType::class, [
                'label' => 'form.nft.category.label',
                'mapped' => false,
                'required' => true,
            ])
        ;
//            ->add('subCategory', EntityType::class,[
//        'label' => 'form.nft.category.label',
//        'class' => Category::class,
//        'choice_label' => 'name',
//        'query_builder' => function (categoryRepository $c) {
//            return $c->createQueryBuilder('c')
//                ->orderBy('c.name', 'ASC');
//        },
//
//
//
//    ])
//        ;

        $builder->addEventListener(FormEvents::SUBMIT, function (FormEvent $event): void {
            $form = $event->getForm();

            $field = $form->get('image');
            $fieldLink = $form->get('imageLink');
            if ($field->getData() === null && $fieldLink->getData() === null) {
                $form->addError(new FormError('MET AU MOINS UNE IMAGE'));
            }
        });
    }

    public function configureOptions(OptionsResolver $resolver): void
    {
        $resolver->setDefaults([
            'data_class' => NFT::class,
        ]);
    }
}
