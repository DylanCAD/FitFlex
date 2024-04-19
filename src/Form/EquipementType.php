<?php

namespace App\Form;

use App\Entity\Equipement;
use Symfony\Component\Form\AbstractType;
use Symfony\Component\Form\FormBuilderInterface;
use Symfony\Component\OptionsResolver\OptionsResolver;
use Symfony\Component\Form\Extension\Core\Type\UrlType;
use Symfony\Component\Form\Extension\Core\Type\FileType;
use Symfony\Component\Form\Extension\Core\Type\TextType;
use Symfony\Component\Form\Extension\Core\Type\HiddenType;
use Symfony\Component\Form\Extension\Core\Type\TextareaType;

class EquipementType extends AbstractType
{
    public function buildForm(FormBuilderInterface $builder, array $options): void
    {
        $builder
            ->add('nomEquipement', TextType::class,[
                'label'=> "Nom de l'equipement",
                'attr'=>[
                    "placeholder"=>"Saisir le nom de l'equipement",
                ],
           ])            
           ->add('descriptionEquipement', TextareaType::class,[
                'label'=> "Description de l'equipement",
                'attr'=>[
                    "placeholder"=>"Saisir la description de l'equipement"
                ]
            ])
            ->add('imageFile', FileType::class,[
                'mapped'=>false,
                'required'=>false,
                'label'=>"Charger l'équipement",
                'attr'=>[
                    'accept'=>".jpg,.png,.gif"
                ],
                'row_attr'=>[
                    'class'=>"d-none"
                ]
            ])
            ->add('imageEquipement', HiddenType::class)
            ->add('lienEquipement', UrlType::class,[
                'label'=> "Lien de l'equipement",
                'attr'=>[
                    "placeholder"=>"Saisir le lien de l'equipement"
                ]
            ])
            ;
    }

    public function configureOptions(OptionsResolver $resolver): void
    {
        $resolver->setDefaults([
            'data_class' => Equipement::class,
        ]);
    }
}