<?php

namespace App\Controller;

use App\Entity\User;
use Symfony\Bundle\FrameworkBundle\Controller\AbstractController;
use Symfony\Component\HttpFoundation\Request;
use Symfony\Component\HttpFoundation\Response;
use Symfony\Component\Routing\Annotation\Route;

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
     * @Route("/profile/edit", name="user_profile_edit")
     */
    public function editProfile(Request $request): Response
    {
        $user = $this->getUser();
        // Handle form submission and update user data
        // Example code to handle form submission and update user data
        // $userForm = $this->createForm(UserType::class, $user);
        // $userForm->handleRequest($request);
        // if ($userForm->isSubmitted() && $userForm->isValid()) {
        //     $this->getDoctrine()->getManager()->flush();
        //     return $this->redirectToRoute('user_profile');
        // }
        return $this->render('user/edit_profile.html.twig', [
            'user' => $user,
            // 'form' => $userForm->createView(),
        ]);
    }
}
