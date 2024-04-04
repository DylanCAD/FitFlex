<?php

namespace App\Controller;

use App\Entity\ExerciceMusculation;
use App\Repository\ExerciceMusculationRepository;
use Symfony\Bundle\FrameworkBundle\Controller\AbstractController;
use Symfony\Component\HttpFoundation\Response;
use Symfony\Component\Routing\Annotation\Route;

class ExerciceMusculationController extends AbstractController
{
    /**
     * @Route("/exercicemusculations", name="exercicemusculations", methods={"GET"})
     */
    public function listeExerciceMusculations(ExerciceMusculationRepository $repo): Response
    {
        $exercicemusculations=$repo->findAll();
        return $this->render('exercice_musculation/listeExerciceMusculations.html.twig', [
            'lesExerciceMusculations' => $exercicemusculations
        ]);
    }

    /**
     * @Route("/typeexercicemusculations/{id}/types", name="exercicemusculation_types", methods={"GET"})
     */
    public function typesExerciceMusculations(int $id, ExerciceMusculationRepository $exerciceMusculationRepository): Response
    {
        $exerciceMusculation = $exerciceMusculationRepository->find($id);

        if (!$exerciceMusculation) {
            throw $this->createNotFoundException('Exercice de musculation non trouvé');
        }

        return $this->render('type_exercice_musculation/listeTypeExerciceMusculations.html.twig', [
            'exerciceMusculation' => $exerciceMusculation
        ]);
    }
}
