<?php

namespace App\Controller;

use App\Entity\Recette;
use App\Repository\RecetteRepository;
use Symfony\Bundle\FrameworkBundle\Controller\AbstractController;
use Symfony\Component\HttpFoundation\Response;
use Symfony\Component\Routing\Annotation\Route;

class RecetteController extends AbstractController
{
    /**
     * @Route("/recettes", name="recettes", methods={"GET"})
     */
    public function listeRecettes(RecetteRepository $repo): Response
    {
        $recettes=$repo->findAll();
        return $this->render('recette/listeRecettes.html.twig', [
            'lesRecettes' => $recettes
        ]);
    }

    /**
     * @Route("/recette/{id}", name="ficheRecette", methods={"GET"})
     */
    public function ficheRecette(RecetteRepository $recetteRepository, $id)
    {
        $recette = $recetteRepository->find($id);

        return $this->render('recette/ficheRecette.html.twig', [
            'laRecette' => $recette
        ]);
    }
}
