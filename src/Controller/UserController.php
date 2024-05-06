<?php

namespace App\Controller;

use App\Entity\User;
use App\Form\UserType;
use App\Repository\UserRepository;
use Doctrine\ORM\EntityManagerInterface;
use Symfony\Component\HttpFoundation\Request;
use Symfony\Component\HttpFoundation\Response;
use Symfony\Component\Routing\Annotation\Route;
use Symfony\Bundle\FrameworkBundle\Controller\AbstractController;
use Symfony\Component\HttpKernel\Exception\NotFoundHttpException;

class UserController extends AbstractController
{
    /**
     * @Route("/profile", name="user_profile")
     */
    public function profile(Request $request): Response
    {
        $user = $this->getUser();
        return $this->render('user/profile.html.twig', [
            'user' => $user,
        ]);
    }

    /**
    * @Route("/user/modif/{id}", name="user_modif", methods={"GET","POST"})
    */
    public function modifUser($id, Request $request, EntityManagerInterface $manager, UserRepository $userRepository)
    {
        $user = $userRepository->find($id);

        if (!$user) {
            throw new NotFoundHttpException('User non trouvé');
        }

        // Créer le formulaire en utilisant le user à modifier
        $form = $this->createForm(UserType::class, $user);
        $form->handleRequest($request);

        if ($form->isSubmitted() && $form->isValid()) 
        {
            // Aucun besoin de persister le message, il est déjà enregistré dans la base de données
            $manager->flush();
        
            $this->addFlash("success", "L'utilisateur a bien été modifié");
            return $this->redirectToRoute('user_profile');
        }

        return $this->render('user/formModifUser.html.twig', [
            'formUser' => $form->createView(),
            'userId' => $id, // Passer l'ID du user au template
        ]);
    }
}
