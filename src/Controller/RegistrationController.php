<?php

namespace App\Controller;

// require_once 'C:/laragon/www/ProjetFitFlex/phpmailer/src/PHPMailer.php';
// require_once 'C:/laragon/www/ProjetFitFlex/phpmailer/src/SMTP.php';

// use PHPMailer\PHPMailer\Exception;

use App\Entity\User;
// use PHPMailer\PHPMailer\PHPMailer;
// use PHPMailer\PHPMailer\SMTP;

use App\Form\UserRegistrationFormType;
use Symfony\Component\HttpFoundation\Request;
// use Symfony\Component\Mailer\MailerInterface;
use Symfony\Component\HttpFoundation\Response;
use Symfony\Component\Routing\Annotation\Route;
use Symfony\Component\Routing\Generator\UrlGeneratorInterface;
use Symfony\Bundle\FrameworkBundle\Controller\AbstractController;
use Symfony\Component\Security\Core\Encoder\UserPasswordEncoderInterface;

class RegistrationController extends AbstractController
{
    /**
     * @Route("/register", name="app_register")
     */
        public function register(Request $request,UserPasswordEncoderInterface $passwordEncoder,UrlGeneratorInterface $urlGenerator): Response 
    //  public function register(Request $request,UserPasswordEncoderInterface $passwordEncoder,MailerInterface $mailer,UrlGeneratorInterface $urlGenerator): Response 
    {
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

            $this->addFlash("success", "Un email vous a été envoyé pour valider votre adresse email.");
    
            // try {
            //     // Configuration de PHPMailer pour utiliser SMTP
            //     $mail = new PHPMailer(true); // true active les exceptions en cas d'erreur

            //     // Configuration SMTP
            //     $mail->SMTPDebug = SMTP::DEBUG_SERVER;
            //     $mail->isSMTP();
            //     $mail->Host = 'smtp.gmail.com'; // Adresse du serveur SMTP
            //     $mail->SMTPAuth = true;
            //     $mail->Username = 'apollift@gmail.com'; // Nom d'utilisateur SMTP
            //     $mail->Password = 'ApolliftTeam'; // Mot de passe SMTP
            //     $mail->SMTPSecure = 'tls'; // Protocole de sécurité
            //     $mail->Port = 587; // Port SMTP

            //     // Destinataire, expéditeur, sujet, etc.
            //     $mail->setFrom('apollift@gmail.com', 'Apollift');
            //     $mail->addAddress($user->getEmail(), $user->getFullName());
            //     $mail->Subject = 'Validation de votre adresse e-mail';
            //     $mail->Body = 'Sending emails is fun again!';
    
            //     // Envoyer l'e-mail
            //     $mail->send();
        
            //     // Redirection vers une autre page après l'inscription
            //     return $this->redirectToRoute('app_login');
            // } 
            // catch (\PHPMailer\PHPMailer\Exception $e) {
            //     // Gérer toutes les exceptions, y compris celles de PHPMailer
            //     echo "Message could not be sent. Mailer Error: {$mail->ErrorInfo}";
            // }
            
            
            
            // Définissez l'adresse IP et le port de Papercut
            $papercutHost = '127.0.0.1';
            $papercutPort = 25;

            ini_set('SMTP', $papercutHost);
            ini_set('smtp_port', $papercutPort);

            $to = $user->getEmail();
            // Construire le corps du message
            $subject = 'Validation de votre adresse e-mail';
            $message = $this->renderView('emails/registration_confirmation.html.twig');
            // En-têtes de l'e-mail
            $headers = 'From: apollift@gmail.com' . "\r\n" .
                       'Reply-To: apollift@gmail.com' . "\r\n" .
                       'X-Mailer: PHP/' . phpversion() . "\r\n" .
                       "MIME-Version: 1.0\r\n" .
                       "Content-Type: text/html; charset=UTF-8\r\n";
            
            // Envoyer l'e-mail
            if (mail($to, $subject, $message, $headers)) {
                // Redirection vers une autre page après l'inscription
                return $this->redirectToRoute('app_login');
            } else {
                // Gérer les erreurs d'envoi de l'e-mail
                // Par exemple, un message d'erreur à l'utilisateur
            }
            
        }
    
        // Rendu du formulaire d'inscription
        return $this->render('registration/register.html.twig', [
            'registrationForm' => $form->createView(),
            'user' => $user, // Passer l'utilisateur au template Twig
        ]);
    }
}    