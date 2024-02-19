<?php

namespace App\Controller;

use App\Entity\Equipement;
use App\Repository\EquipementRepository;
use Symfony\Bundle\FrameworkBundle\Controller\AbstractController;
use Symfony\Component\HttpFoundation\Response;
use Symfony\Component\Routing\Annotation\Route;

class EquipementController extends AbstractController
{
    /**
     * @Route("/equipements", name="equipements", methods={"GET"})
     */
    public function listeEquipements(EquipementRepository $repo): Response
    {
        $equipements=$repo->findAll();
        return $this->render('equipement/listeEquipements.html.twig', [
            'lesEquipements' => $equipements
        ]);
    }
}
