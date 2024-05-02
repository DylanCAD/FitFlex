<?php

namespace App\Controller;

use App\Entity\Message;
use App\Form\MessageType;
use App\Repository\MessageRepository;
use Doctrine\ORM\EntityManagerInterface;
use Symfony\Component\HttpFoundation\Request;
use Symfony\Component\Security\Core\Security;
use Symfony\Component\HttpFoundation\Response;
use Symfony\Component\Routing\Annotation\Route;
use Symfony\Bundle\FrameworkBundle\Controller\AbstractController;
use Symfony\Component\HttpKernel\Exception\NotFoundHttpException;

class ChatController extends AbstractController
{
    /**
     * @Route("/chat", name="chat")
     */
    public function index(): Response
    {
        // Récupérer les messages depuis la base de données
        $messages = $this->getDoctrine()->getRepository(Message::class)->findAll();

        return $this->render('chat/index.html.twig', [
            'messages' => $messages,
        ]);
    }

    /**
     * @Route("/send-message", name="send_message", methods={"POST"})
     */
    public function sendMessage(Request $request, Security $security): Response
    {
        $content = $request->request->get('content');

        // Récupérer l'utilisateur actuellement connecté
        $user = $security->getUser();

        // Créer un nouvel objet Message et l'associer à l'utilisateur
        $message = new Message();
        $message->setContent($content);
        $message->setUser($user);

        $entityManager = $this->getDoctrine()->getManager();
        $entityManager->persist($message);
        $entityManager->flush();

        // Rediriger vers la page du chat
        return $this->redirectToRoute('chat');
    }

    /**
    * @Route("/message/modif/{id}", name="message_modif", methods={"GET","POST"})
    */
    public function modifMessage($id, Request $request, EntityManagerInterface $manager, MessageRepository $messageRepository)
    {
        $message = $messageRepository->find($id);

        if (!$message) {
            throw new NotFoundHttpException('Message non trouvé');
        }

        // Créer le formulaire en utilisant le message à modifier
        $form = $this->createForm(MessageType::class, $message);
        $form->handleRequest($request);

        if ($form->isSubmitted() && $form->isValid()) 
        {
            // Aucun besoin de persister le message, il est déjà enregistré dans la base de données
            $manager->flush();
        
            $this->addFlash("success", "Le message a bien été modifié");
            return $this->redirectToRoute('chat');
        }

        return $this->render('chat/formModifMessage.html.twig', [
            'formMessage' => $form->createView(),
            'messageId' => $id, // Passer l'ID du message au template
        ]);
    }

    /**
     * @Route("/message/suppression/{id}", name="message_suppression", methods={"GET"})
     */
    public function suppressionMessage($id, EntityManagerInterface $manager): Response
    {
        $message = $manager->getRepository(Message::class)->find($id);
    
        if (!$message) {
            throw new NotFoundHttpException('Message non trouvé');
        }
    
        $manager->remove($message);
        $manager->flush();
    
        $this->addFlash("success", "Le message a bien été supprimé");
        return $this->redirectToRoute('chat');
    }
}
