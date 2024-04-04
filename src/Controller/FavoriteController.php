<?php

namespace App\Controller;

use App\Entity\FavoriteExercise;
use App\Entity\TypeExerciceMusculation;
use App\Entity\User;
use Doctrine\ORM\EntityManagerInterface;
use Symfony\Bundle\FrameworkBundle\Controller\AbstractController;
use Symfony\Component\HttpFoundation\Request;
use Symfony\Component\HttpFoundation\Response;
use Symfony\Component\Routing\Annotation\Route;

class FavoriteController extends AbstractController
{
    private $entityManager;

    public function __construct(EntityManagerInterface $entityManager)
    {
        $this->entityManager = $entityManager;
    }

    /**
 * @Route("/favorite/add", name="favorite_add", methods={"POST"})
 */
public function addToFavorites(Request $request): Response
{
    $this->denyAccessUnlessGranted('IS_AUTHENTICATED_FULLY');

    // Récupération de l'utilisateur
    $user = $this->getUser();

    // Vérification que l'utilisateur est bien un objet User
    if (!$user instanceof User) {
        return $this->json(['error' => 'Invalid user'], Response::HTTP_BAD_REQUEST);
    }

    $exerciseId = $request->request->get('exerciseId');

    // Récupérer l'exercice
    $exercise = $this->entityManager->getRepository(TypeExerciceMusculation::class)->find($exerciseId);

    if (!$exercise) {
        return $this->json(['error' => 'Exercise not found'], Response::HTTP_NOT_FOUND);
    }

    // Ajouter l'exercice aux favoris
    if (!$user->hasFavoriteExercise($exerciseId)) {
        $favoriteExercise = new FavoriteExercise();
        $favoriteExercise->setUser($user);
        $favoriteExercise->setExerciseId($exerciseId);
        
        // Associer l'exercice de musculation
        $favoriteExercise->setTypeExerciceMusculation($exercise);

        $this->entityManager->persist($favoriteExercise);
        $this->entityManager->flush();

        // Mettre à jour is_favorite
        $exercise->setIsFavorite(true);
        $this->entityManager->flush();
    }

    return $this->json(['status' => 'added']);
}

    /**
     * @Route("/favorite/remove", name="favorite_remove", methods={"POST"})
     */
    public function removeFromFavorites(Request $request): Response
    {
        $this->denyAccessUnlessGranted('IS_AUTHENTICATED_FULLY');

        // Récupération de l'utilisateur
        $user = $this->getUser();

        // Vérification que l'utilisateur est bien un objet User
        if (!$user instanceof User) {
            return $this->json(['error' => 'Invalid user'], Response::HTTP_BAD_REQUEST);
        }

        $exerciseId = $request->request->get('exerciseId');

        // Récupérer l'exercice
        $exercise = $this->entityManager->getRepository(TypeExerciceMusculation::class)->find($exerciseId);

        if (!$exercise) {
            return $this->json(['error' => 'Exercise not found'], Response::HTTP_NOT_FOUND);
        }

        // Retirer l'exercice des favoris
        $favoriteExercise = $this->entityManager->getRepository(FavoriteExercise::class)->findOneBy([
            'user' => $user,
            'exerciseId' => $exerciseId
        ]);

        if ($favoriteExercise) {
            $this->entityManager->remove($favoriteExercise);
            $this->entityManager->flush();

            // Mettre à jour is_favorite
            $exercise->setIsFavorite(false);
            $this->entityManager->flush();
        }

        return $this->json(['status' => 'removed']);
    }

    /**
     * @Route("/favorite/exercises", name="favorite_exercises", methods={"GET"})
     */
    public function favoriteExercises(): Response
    {
        // Récupérer l'utilisateur connecté
        $user = $this->getUser();

        // Récupérer les exercices favoris de l'utilisateur avec leurs détails
        $favoriteExercises = $this->getDoctrine()->getRepository(FavoriteExercise::class)->findBy(['user' => $user]);

        // Passer les exercices favoris à la vue
        return $this->render('favorite/exercises.html.twig', [
            'favoriteExercises' => $favoriteExercises
        ]);
    }
}
