<?php

namespace App\Controller;

use App\Entity\Performance;
use App\Repository\PerformanceRepository;
use Symfony\Bundle\FrameworkBundle\Controller\AbstractController;
use Symfony\Component\HttpFoundation\Response;
use Symfony\Component\Routing\Annotation\Route;

class PerformanceController extends AbstractController
{
    /**
     * @Route("/performances", name="performances", methods={"GET"})
     */
    public function listePerformances(PerformanceRepository $repo): Response
    {
        $performances=$repo->findAll();
        return $this->render('performance/listePerformances.html.twig', [
            'lesPerformances' => $performances
        ]);
    }
}