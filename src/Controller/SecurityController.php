<?php

namespace App\Controller;

use App\Entity\User;
use Symfony\Component\HttpFoundation\Request;
use Symfony\Component\HttpFoundation\Response;
use Symfony\Component\Routing\Annotation\Route;
use Symfony\Component\Routing\Generator\UrlGeneratorInterface;
use Symfony\Bundle\FrameworkBundle\Controller\AbstractController;
use Symfony\Component\Security\Http\Authentication\AuthenticationUtils;

class SecurityController extends AbstractController
{
    /**
     * @Route("/login", name="app_login")
     */
    public function login(AuthenticationUtils $authenticationUtils): Response
    {
        // Récupérer les erreurs de connexion s'il y en a
        $error = $authenticationUtils->getLastAuthenticationError();

        // Dernier nom d'utilisateur saisi par l'utilisateur
        $lastEmail = $authenticationUtils->getLastUsername();

        return $this->render('security/login.html.twig', ['last_email' => $lastEmail, 'error' => $error]);
    }

    /**
     * @Route("/logout", name="app_logout")
     */
    public function logout()
    {
        // La route /logout ne nécessite pas d'action, Symfony gère la déconnexion automatiquement
        throw new \LogicException('This method can be blank - it will be intercepted by the logout key on your firewall.');
    }

/**
 * @Route("/forgot-password", name="app_forgot_password")
 */
public function forgotPassword(Request $request)
{
    // Récupérer l'adresse e-mail soumise dans le formulaire
    $email = $request->request->get('_username');

    // Recherchez l'utilisateur avec cette adresse e-mail dans la base de données
    $userRepository = $this->getDoctrine()->getRepository(User::class);
    $user = $userRepository->findOneBy(['email' => $email]);

    // Si l'utilisateur existe, générez un token de réinitialisation de mot de passe
    if ($user) {
        $user->generatePasswordResetToken();

        // Enregistrez l'utilisateur mis à jour dans la base de données
        $entityManager = $this->getDoctrine()->getManager();
        $entityManager->persist($user);
        $entityManager->flush();

        // Envoyez un e-mail de réinitialisation de mot de passe à l'utilisateur
        $resetLink = $this->generateUrl('app_reset_password', ['token' => $user->getResetToken()], UrlGeneratorInterface::ABSOLUTE_URL);
        $emailSubject = 'Réinitialisation de votre mot de passe';
        $emailBody = $this->renderView('emails/reset_password.html.twig', ['resetLink' => $resetLink]);
        $this->sendEmail($user->getEmail(), $emailSubject, $emailBody);

        // Affichez un message de succès à l'utilisateur
        $this->addFlash('success', 'Un e-mail de réinitialisation de mot de passe a été envoyé à votre adresse e-mail.');
    } else {
        // Si l'utilisateur n'existe pas, affichez un message d'erreur
        $this->addFlash('danger', 'Aucun utilisateur trouvé avec cette adresse e-mail.');
    }

    // Redirigez l'utilisateur vers la page de connexion
    return $this->redirectToRoute('app_login');
}

/**
 * Envoyer un e-mail en utilisant Papercut.
 */
private function sendEmail(string $to, string $subject, string $body)
{
    // Définissez l'adresse IP et le port de Papercut
    $papercutHost = '127.0.0.1';
    $papercutPort = 25;

    ini_set('SMTP', $papercutHost);
    ini_set('smtp_port', $papercutPort);

    // En-têtes de l'e-mail
    $headers = 'From: apollift@gmail.com' . "\r\n" .
               'Reply-To: apollift@gmail.com' . "\r\n" .
               'X-Mailer: PHP/' . phpversion() . "\r\n" .
               "MIME-Version: 1.0\r\n" .
               "Content-Type: text/html; charset=UTF-8\r\n";

    // Envoyer l'e-mail
    mail($to, $subject, $body, $headers);
}
}
