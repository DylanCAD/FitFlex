<?php

namespace App\Form;

use App\Entity\Performance;
use App\Entity\TypeExerciceMusculation;
use Symfony\Component\Form\AbstractType;
use Symfony\Component\Form\FormBuilderInterface;
use Symfony\Bridge\Doctrine\Form\Type\EntityType;
use Symfony\Component\OptionsResolver\OptionsResolver;
use Symfony\Component\Form\Extension\Core\Type\UrlType;
use Symfony\Component\Form\Extension\Core\Type\FileType;
use Symfony\Component\Form\Extension\Core\Type\TextType;
use Symfony\Component\Form\Extension\Core\Type\HiddenType;
use Symfony\Component\Form\Extension\Core\Type\IntegerType;
use Symfony\Component\Form\Extension\Core\Type\TextareaType;

class PerformanceType extends AbstractType
{
    public function buildForm(FormBuilderInterface $builder, array $options): void
    {
        $builder
            ->add('repetitions', IntegerType::class,[
                'label'=> "Nombre de répétition",
                'attr'=>[
                    "placeholder"=>"Saisir le nombre de répétition",
                ],
            ])
           ->add('poidsUtilise', IntegerType::class,[
            'label'=> "Poids utiliser",
            'attr'=>[
                "placeholder"=>"Saisir le poids utiliser",
            ],
            ])
            ->add('serie', IntegerType::class,[
                'label'=> "Nombre de série",
                'attr'=>[
                    "placeholder"=>"Saisir le nombre de série",
                ],
            ])             
           ->add('commentairesForme', TextareaType::class,[
                'label'=> "Commentaire sur votre forme",
                'attr'=>[
                    "placeholder"=>"Saisir un commentaire sur votre forme"
                ]
            ])
            ->add('exercice', EntityType::class, [ 
                'label'=> "Exercice",
                'class' => TypeExerciceMusculation::class,
                'choice_label' => 'nomTypeExerciceMusculation',
                'required' => true,
            ])
            ;
    }

    public function configureOptions(OptionsResolver $resolver): void
    {
        $resolver->setDefaults([
            'data_class' => Performance::class,
        ]);
    }
}