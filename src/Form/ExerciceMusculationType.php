<?php

namespace App\Form;

use App\Entity\ExerciceMusculation;
use Symfony\Component\Form\AbstractType;
use Symfony\Component\Form\FormBuilderInterface;
use Symfony\Component\OptionsResolver\OptionsResolver;
use Symfony\Component\Form\Extension\Core\Type\UrlType;
use Symfony\Component\Form\Extension\Core\Type\FileType;
use Symfony\Component\Form\Extension\Core\Type\TextType;
use Symfony\Component\Form\Extension\Core\Type\HiddenType;
use Symfony\Component\Form\Extension\Core\Type\NumberType;
use Symfony\Component\Form\Extension\Core\Type\TextareaType;

class ExerciceMusculationType extends AbstractType
{
    public function buildForm(FormBuilderInterface $builder, array $options): void
    {
        $builder
            ->add('nomExerciceMusculation', TextType::class,[
                'label'=> "Nom du groupe musculaire",
                'attr'=>[
                    "placeholder"=>"Saisir le nom du groupe musculaire",
                ],
            ])            
            ->add('imageFile', FileType::class,[
                'mapped'=>false,
                'required'=>false,
                'label'=>"Charger le groupe musculaire",
                'attr'=>[
                    'accept'=>".jpg,.png,.gif"
                ],
                'row_attr'=>[
                    'class'=>"d-none"
                ]
            ])
            ->add('imageExerciceMusculation', HiddenType::class)
            ;
    }

    public function configureOptions(OptionsResolver $resolver): void
    {
        $resolver->setDefaults([
            'data_class' => ExerciceMusculation::class,
        ]);
    }
}