<?php

namespace App\Controller;

use App\Entity\Performance;
use App\Form\PerformanceType;
use Doctrine\ORM\EntityManagerInterface;
use App\Repository\PerformanceRepository;
use Symfony\Component\HttpFoundation\Request;
use Symfony\Component\HttpFoundation\Response;
use Symfony\Component\Routing\Annotation\Route;
use SebastianBergmann\CodeCoverage\Util\Percentage;
use Symfony\Bundle\FrameworkBundle\Controller\AbstractController;
use Symfony\Component\HttpKernel\Exception\NotFoundHttpException;

class PerformanceController extends AbstractController
{
    /**
     * @Route("/performances", name="performance_afficher", methods={"GET"})
     */
    public function listePerformances(PerformanceRepository $repo): Response
    {
        $performances=$repo->findAll();
        $graphData = [];
        foreach ($performances as $performance) {
            $graphData[] = [
                'createdAt' => $performance->getCreatedAt()->format('Y-m-d H:i:s'),
                'updatedAt' => $performance->getUpdatedAt() ? $performance->getUpdatedAt()->format('Y-m-d H:i:s') : null,
                'poidsUtilise' => $performance->getPoidsUtilise(),
                'serie' => $performance->getSerie(),
                'repetitions' => $performance->getRepetitions(),
                'exercice' => $performance->getExercice()->getNomTypeExerciceMusculation()
            ];
        }
    
        return $this->render('performance/listePerformances.html.twig', [
            'lesPerformances' => $performances,
            'graphData' => json_encode($graphData) // Passer les données JSON à la vue
        ]);
    }

    /**
     * @Route("/performance/ajout", name="performance_ajout", methods={"GET","POST"})
     */
    public function ajoutPerformance( Request $request, EntityManagerInterface $manager)
    {
        $performance=new Performance();
        $form=$this->createForm(PerformanceType::class, $performance);
        $form->handleRequest($request);
        if($form->isSubmitted() && $form->isValid())
        {
            $manager->persist($performance);
            $manager->flush();
            $this->addFlash("success", "La performance a bien été ajoutée");
            return $this->redirectToRoute('performance_afficher');
        }
        return $this->render('performance/formAjoutPerformance.html.twig', [
            'formPerformance' => $form->createView(),
            
        ]);
    }

    /**
    * @Route("/performance/modif/{id}", name="performance_modif", methods={"GET","POST"})
    */
    public function modifPerformance($id, Request $request, EntityManagerInterface $manager, PerformanceRepository $performanceRepository)
    {
        $performance = $performanceRepository->find($id);

        if (!$performance) {
            throw new NotFoundHttpException('Performance non trouvé');
        }

        // Créer le formulaire en utilisant la performance à modifier
        $form = $this->createForm(PerformanceType::class, $performance);
        $form->handleRequest($request);

        if ($form->isSubmitted() && $form->isValid()) 
        {
            // Aucun besoin de persister la performance, elle est déjà enregistré dans la base de données
            $manager->flush();
        
            $this->addFlash("success", "La performance a bien été modifiée");
            return $this->redirectToRoute('performance_afficher');
        }

        return $this->render('performance/formModifPerformance.html.twig', [
            'formPerformance' => $form->createView(),
            'performanceId' => $id, // Passer l'ID de la performance au template
        ]);
    }

    /**
     * @Route("/performance/suppression/{id}", name="performance_suppression", methods={"GET"})
     */
    public function suppressionPerformance($id, EntityManagerInterface $manager): Response
    {
        $performance = $manager->getRepository(Performance::class)->find($id);
    
        if (!$performance) {
            throw new NotFoundHttpException('Performance non trouvée');
        }
    
        $manager->remove($performance);
        $manager->flush();
    
        $this->addFlash("success", "La performance a bien été supprimée");
        return $this->redirectToRoute('performance_afficher');
    }

}