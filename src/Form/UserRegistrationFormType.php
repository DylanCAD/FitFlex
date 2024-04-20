<?php

namespace App\Form;

use App\Entity\User;
use Symfony\Component\Form\AbstractType;
use Symfony\Component\Form\FormBuilderInterface;
use Symfony\Component\OptionsResolver\OptionsResolver;
use Symfony\Component\Form\Extension\Core\Type\FileType;
use Symfony\Component\Form\Extension\Core\Type\TextType;
use Symfony\Component\Form\Extension\Core\Type\EmailType;
use Symfony\Component\Form\Extension\Core\Type\ChoiceType;
use Symfony\Component\Form\Extension\Core\Type\HiddenType;
use Symfony\Component\Form\Extension\Core\Type\PasswordType;
use Symfony\Component\Form\Extension\Core\Type\RepeatedType;

class UserRegistrationFormType extends AbstractType
{
    public function buildForm(FormBuilderInterface $builder, array $options)
    {
        $builder
            ->add('email', EmailType::class,[
                'label'=> "E-mail *",
                'attr'=>[
                    "placeholder"=>"Saisir votre e-mail",
                ],
            ])
            ->add('password', RepeatedType::class, [
                'type' => PasswordType::class,
                'first_options' => ['label' => 'Mot de passe *', 
                'attr'=>["placeholder"=>"Saisir votre mot de passe",],],
                'second_options' => ['label' => 'Répéter le mot de passe *',
                'attr'=>["placeholder"=>"Saisir à nouveau votre mot de passe",],],
            ])
            ->add('nom_User', TextType::class,[               
                'label'=> "Nom *",
                'attr'=>[
                    "placeholder"=>"Saisir votre nom",
                ],
           ])
            ->add('prenom_User', TextType::class,[                
                'label'=> "Prénom *",
                'attr'=>[
                "placeholder"=>"Saisir votre prénom",
            ],
            ])
            ->add('sexe_User', ChoiceType::class, [
                'label'=> "Sexe",
                'choices'  => [
                    'Homme' => 'Homme',
                    'Femme' => 'Femme',
                ],
            ])            
            ->add('imageFile', FileType::class,[
                    'mapped'=>false,
                    'required'=>false,
                    'label'=>"Charger votre photo de profil",
                    'attr'=>[
                        'accept'=>".jpg,.png,.gif"
                    ],
                    'row_attr'=>[
                        'class'=>"d-none"
                    ]
                ])
            ->add('avatar_User', HiddenType::class)
            ->add('age_User', TextType::class, [
                'label'=> "Âge",
                'attr'=>[
                    "placeholder"=>"Saisir votre âge",
                ],
                'required' => false
                ])
            ->add('taille_User', TextType::class, [                
                'label'=> "Taille",
                'attr'=>[
                "placeholder"=>"Saisir votre taille",
            ],
            'required' => false
            ])
            ->add('poids_User', TextType::class, [
                'label'=> "Poids",
                'attr'=>[
                "placeholder"=>"Saisir votre poids",
            ],
            'required' => false
            ])
            ->add('level_User', ChoiceType::class, [
                'label'=> "Niveau",
                'choices'  => [
                    'Débutant' => 'Débutant',
                    'Intermédiaire' => 'Intermédiaire',
                    'Avancé' => 'Avancé',
                ],
            ])            
            ->add('objectif_User', ChoiceType::class, [
                'label'=> "Objectif",
                'choices'  => [
                    'Prise de masse' => 'Prise de masse',
                    'Perte de poids' => 'Perte de poids',
                ],
            ]);
            }

    public function configureOptions(OptionsResolver $resolver)
    {
        $resolver->setDefaults([
            'data_class' => User::class,
        ]);
    }
}
