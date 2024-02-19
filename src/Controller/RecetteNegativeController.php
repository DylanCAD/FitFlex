<?php

namespace App\Controller;

use App\Entity\RecetteNegative;
use App\Repository\RecetteNegativeRepository;
use Symfony\Bundle\FrameworkBundle\Controller\AbstractController;
use Symfony\Component\HttpFoundation\Response;
use Symfony\Component\Routing\Annotation\Route;

class RecetteNegativeController extends AbstractController
{
    /**
     * @Route("/recettenegatives", name="recettenegatives", methods={"GET"})
     */
    public function listeRecetteNegatives(RecetteNegativeRepository $repo): Response
    {
        $recettenegatives=$repo->findAll();
        return $this->render('recette_negative/listeRecetteNegatives.html.twig', [
            'lesRecetteNegatives' => $recettenegatives
        ]);
    }

    /**
     * @Route("/recettenegative/{id}", name="ficheRecetteNegative", methods={"GET"})
     */
    public function ficheRecetteNegative(RecetteNegativeRepository $recettenegativeRepository, $id)
    {
        $recettenegative = $recettenegativeRepository->find($id);

        return $this->render('recette_negative/ficheRecetteNegative.html.twig', [
            'laRecetteNegative' => $recettenegative
        ]);
    }
}
