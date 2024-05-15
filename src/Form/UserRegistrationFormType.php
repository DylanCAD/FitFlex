<?php

namespace App\Form;

use App\Entity\User;
use Symfony\Component\Form\AbstractType;
use Symfony\Component\Form\FormBuilderInterface;
use Symfony\Component\Validator\Constraints\IsTrue;
use Symfony\Component\Validator\Constraints\NotBlank;
use Symfony\Component\OptionsResolver\OptionsResolver;
use Symfony\Component\Form\Extension\Core\Type\FileType;
use Symfony\Component\Form\Extension\Core\Type\TextType;
use Symfony\Component\Form\Extension\Core\Type\EmailType;
use Symfony\Component\Form\Extension\Core\Type\ChoiceType;
use Symfony\Component\Form\Extension\Core\Type\HiddenType;
use Symfony\Component\Form\Extension\Core\Type\CheckboxType;
use Symfony\Component\Form\Extension\Core\Type\PasswordType;
use Symfony\Component\Form\Extension\Core\Type\RepeatedType;
use Symfony\Component\Routing\Generator\UrlGeneratorInterface;

class UserRegistrationFormType extends AbstractType
{

    private $urlGenerator;

    public function __construct(UrlGeneratorInterface $urlGenerator)
    {
        $this->urlGenerator = $urlGenerator;
    }
    
    public function buildForm(FormBuilderInterface $builder, array $options)
    {

        $privacyPolicyLink = $this->urlGenerator->generate('footer_politique_confidentialite');
        $conditionsGeneralesLink = $this->urlGenerator->generate('footer_conditions_generales');

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
                    ],
                    'constraints' => [
                        new NotBlank([ // Ajoute la contrainte de validation NotBlank
                            'message' => 'Veuillez charger une photo de profil.',
                        ]),
                    ],
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
            ])
            ->add('agreeTerms', CheckboxType::class, [
                'mapped' => false,
                'label' => sprintf(
                    'J\'accepte la <a href="%s" class="custom-link white-text">politique de confidentialité</a> et les <a href="%s" class="custom-link white-text">conditions générales d\'utilisation</a>.',
                    $privacyPolicyLink,
                    $conditionsGeneralesLink
                ),
                'label_html' => true,
                'constraints' => [
                    new IsTrue([
                        'message' => 'J\'accepte la politique de confidentialité et les conditions générales d\'utilisation.',
                    ]),
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
