<?php

namespace App\Form;

use App\Entity\Recette;
use Symfony\Component\Form\AbstractType;
use Symfony\Component\Form\FormBuilderInterface;
use Symfony\Component\OptionsResolver\OptionsResolver;
use Symfony\Component\Form\Extension\Core\Type\UrlType;
use Symfony\Component\Form\Extension\Core\Type\FileType;
use Symfony\Component\Form\Extension\Core\Type\TextType;
use Symfony\Component\Form\Extension\Core\Type\HiddenType;
use Symfony\Component\Form\Extension\Core\Type\NumberType;
use Symfony\Component\Form\Extension\Core\Type\TextareaType;

class RecetteType extends AbstractType
{
    public function buildForm(FormBuilderInterface $builder, array $options): void
    {
        $builder
            ->add('nomRecette', TextType::class,[
                'label'=> "Nom de la recette",
                'attr'=>[
                    "placeholder"=>"Saisir le nom de la recette",
                ],
           ])            
            ->add('imageFile', FileType::class,[
                'mapped'=>false,
                'required'=>false,
                'label'=>"Charger la recette",
                'attr'=>[
                    'accept'=>".jpg,.png,.gif"
                ],
                'row_attr'=>[
                    'class'=>"d-none"
                ]
            ])
            ->add('imageRecette', HiddenType::class)
            ->add('personneRecette', TextType::class,[
                'label'=> "Nombre de personne",
                'attr'=>[
                    "placeholder"=>"Saisir le nombre de personne"
                ]
            ])
            ->add('preparationRecette', TextareaType::class,[
                'label'=> "Preparation",
                'attr'=>[
                    "placeholder"=>"Saisir la preparation"
                ]
            ])
            ->add('cuissonRecette', TextType::class,[
                'label'=> "Temps de cuisson",
                'attr'=>[
                    "placeholder"=>"Saisir le temps de cuisson"
                ]
            ])
            ->add('ingredientRecette', TextareaType::class,[
                'label'=> "Ingredient",
                'attr'=>[
                    "placeholder"=>"Saisir les ingredient"
                ]
            ])
            ->add('preparationdureeRecette', TextType::class,[
                'label'=> "Temps de preparation",
                'attr'=>[
                    "placeholder"=>"Saisir le temps de preparation"
                ]
            ])
            ->add('typeRecette', TextType::class,[
                'label'=> "Type de la recette",
                'attr'=>[
                    "placeholder"=>"Saisir le type de la recette"
                ]
            ])
            ;
    }

    public function configureOptions(OptionsResolver $resolver): void
    {
        $resolver->setDefaults([
            'data_class' => Recette::class,
        ]);
    }
}