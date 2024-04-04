<?php

namespace App\Form;

use App\Entity\TypeExerciceMusculation;
use Symfony\Component\Form\AbstractType;
use Symfony\Component\Form\FormBuilderInterface;
use Symfony\Component\OptionsResolver\OptionsResolver;
use Symfony\Component\Form\Extension\Core\Type\UrlType;
use Symfony\Component\Form\Extension\Core\Type\TextType;
use Symfony\Component\Form\Extension\Core\Type\NumberType;
use Symfony\Component\Form\Extension\Core\Type\TextareaType;

class TypeExerciceMusculationType extends AbstractType
{
    public function buildForm(FormBuilderInterface $builder, array $options): void
    {
        $builder
            ->add('nomTypeExerciceMusculation', TextType::class,[
                'label'=> "Nom de l'exercice de musculation *",
                'attr'=>[
                    "placeholder"=>"Saisir le nom de l'exercice de musculation",
                ],
           ])            
            ->add('imageTypeExerciceMusculation', TextType::class,[
                'label'=> "Image de l'exercice de musculation",
                'attr'=>[
                    "placeholder"=>"Saisir l'image de l'exercice de musculation"
                ]
            ])
            ->add('titreTypeExerciceMusculation', TextType::class,[
                'label'=> "Muscle",
                'attr'=>[
                    "placeholder"=>"Saisir le muscle"
                ]
            ])
            ->add('descriptionTypeExerciceMusculation', TextareaType::class,[
                'label'=> "Description de l'exercice de musculation",
                'attr'=>[
                    "placeholder"=>"Saisir la description de l'exercice de musculation"
                ]
            ])
            ;
    }

    public function configureOptions(OptionsResolver $resolver): void
    {
        $resolver->setDefaults([
            'data_class' => TypeExerciceMusculation::class,
        ]);
    }
}