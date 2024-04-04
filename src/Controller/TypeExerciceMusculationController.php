<?php

namespace App\Controller;

use App\Entity\TypeExerciceMusculation;
use App\Repository\TypeExerciceMusculationRepository;
use Symfony\Bundle\FrameworkBundle\Controller\AbstractController;
use Symfony\Component\HttpFoundation\Response;
use Symfony\Component\Routing\Annotation\Route;

class TypeExerciceMusculationController extends AbstractController
{
    /**
     * @Route("/typeexercicemusculations", name="typeexercicemusculations", methods={"GET"})
     */
    public function listeTypeExerciceMusculations(TypeExerciceMusculationRepository $repo): Response
    {
        $typeexercicemusculations = $repo->findAll();
        
        return $this->render('type_exercice_musculation/listeTypeExerciceMusculations.html.twig', [
            'lesTypeExerciceMusculations' => $typeexercicemusculations
        ]);
    }

    /**
     * @Route("/typeexercicemusculation/{id}", name="ficheTypeExerciceMusculation", methods={"GET"})
     */
    public function ficheTypeExerciceMusculation(TypeExerciceMusculationRepository $typeexercicemusculationRepository, $id)
    {
        $typeexercicemusculation = $typeexercicemusculationRepository->find($id);

        return $this->render('type_exercice_musculation/ficheTypeExerciceMusculation.html.twig', [
            'leTypeExerciceMusculation' => $typeexercicemusculation
        ]);
    }
}
