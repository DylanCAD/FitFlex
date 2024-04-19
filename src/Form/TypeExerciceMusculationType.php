<?php

namespace App\Form;

use App\Entity\ExerciceMusculation;
use App\Entity\TypeExerciceMusculation;
use Symfony\Component\Form\AbstractType;
use Symfony\Component\Form\FormBuilderInterface;
use Symfony\Bridge\Doctrine\Form\Type\EntityType;
use Symfony\Component\Validator\Constraints\NotBlank;
use Symfony\Component\OptionsResolver\OptionsResolver;
use Symfony\Component\Form\Extension\Core\Type\UrlType;
use Symfony\Component\Form\Extension\Core\Type\FileType;
use Symfony\Component\Form\Extension\Core\Type\TextType;
use Symfony\Component\Form\Extension\Core\Type\HiddenType;
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
            ->add('exerciceMusculations', EntityType::class, [ 
                'class' => ExerciceMusculation::class,
                'choice_label' => 'nomExerciceMusculation',
                'label'=> "Groupe musculaire associé(s)",
                'multiple'=>true,
                'by_reference'=>false,
                'attr'=>[
                    'class'=>"selectExercices select2-selection-text" // Ajoutez la classe ici
                ],
                'choice_attr' => function($choice, $key, $value) {
                    return ['class' => 'select2-option-text'];
                }
            ])                 
            ->add('imageFile', FileType::class,[
                'mapped'=>false,
                'required'=>false,
                'label'=>"Charger l'exercice de musculation",
                'attr'=>[
                    'accept'=>".jpg,.png,.gif"
                ],
                'row_attr'=>[
                    'class'=>"d-none"
                ],
                'constraints' => [
                    new NotBlank([ // Ajoute la contrainte de validation NotBlank
                        'message' => 'Veuillez charger une image.',
                    ]),
                ],
            ])
            ->add('imageTypeExerciceMusculation', HiddenType::class)
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