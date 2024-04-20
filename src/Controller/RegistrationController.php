<?php

namespace App\Controller;

use App\Entity\User;
use App\Form\UserRegistrationFormType;
use Symfony\Bundle\FrameworkBundle\Controller\AbstractController;
use Symfony\Component\HttpFoundation\Request;
use Symfony\Component\HttpFoundation\Response;
use Symfony\Component\Routing\Annotation\Route;
use Symfony\Component\Security\Core\Encoder\UserPasswordEncoderInterface;
use Symfony\Component\Mailer\MailerInterface;
use Symfony\Component\Mime\Email;
use Symfony\Component\Routing\Generator\UrlGeneratorInterface;

class RegistrationController extends AbstractController
{
    /**
     * @Route("/register", name="app_register")
     */
    public function register(
        Request $request,
        UserPasswordEncoderInterface $passwordEncoder,
        MailerInterface $mailer,
        UrlGeneratorInterface $urlGenerator
    ): Response {
        $user = new User(); // Création d'une nouvelle instance de l'entité User
        $form = $this->createForm(UserRegistrationFormType::class, $user);
        $form->handleRequest($request);
    
        if ($form->isSubmitted() && $form->isValid()) 
        {
            // On récupère l'image sélectionnée
            $fichierImage = $form->get('imageFile')->getData();
            if ($fichierImage != null) {
                // On récupère le nom de l'image existante
                $ancienNomImage = $user->getAvatarUser();
                // On construit le chemin complet du fichier existant
                $cheminImageExistante = $this->getParameter('imagesUsersDestination') . $ancienNomImage;
                // On vérifie si l'image existante est un fichier
                if (file_exists($cheminImageExistante) && is_file($cheminImageExistante)) {
                    // On supprime l'ancien fichier
                    unlink($cheminImageExistante);
                }
                // On crée le nom du nouveau fichier
                $nouveauNomImage = 'image/photoProfile/' . md5(uniqid()) . "." . $fichierImage->guessExtension();
                // On déplace le fichier chargé dans le dossier public
                $fichierImage->move($this->getParameter('imagesUsersDestination'), $nouveauNomImage);
                $user->setAvatarUser($nouveauNomImage);
            }
            // Traitement du formulaire lorsque celui-ci est soumis et valide
    
            // Hashage du mot de passe
            $hashedPassword = $passwordEncoder->encodePassword($user, $user->getPassword());
            $user->setPassword($hashedPassword);
    
            // Génération du token de confirmation
            $user->generateConfirmationToken();
    
            // Enregistrement de l'utilisateur en base de données
            $entityManager = $this->getDoctrine()->getManager();
            $entityManager->persist($user);
            $entityManager->flush();
    
            // Envoi de l'e-mail de confirmation
            $email = (new Email())
                ->from('fitflex_team@outlook.com') // Remplacez par votre adresse e-mail d'expéditeur
                ->to($user->getEmail())
                ->subject('Confirmation d\'inscription')
                ->html($this->renderView('emails/registration_confirmation.html.twig', [
                    'confirmationUrl' => $urlGenerator->generate('confirm_registration', ['token' => $user->getConfirmationToken()])
                ]));
    
            $mailer->send($email);
    
            // Redirection vers une autre page après l'inscription
            return $this->redirectToRoute('app_login');
        }
    
        // Rendu du formulaire d'inscription
        return $this->render('registration/register.html.twig', [
            'registrationForm' => $form->createView(),
            'user' => $user, // Passer l'utilisateur au template Twig
        ]);
    }
}    