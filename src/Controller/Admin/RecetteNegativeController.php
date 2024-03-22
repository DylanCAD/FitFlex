<?php

namespace App\Controller\Admin;

use App\Entity\RecetteNegative;
use App\Form\RecetteNegativeType;
use Doctrine\ORM\EntityManager;
use Doctrine\ORM\Mapping\Entity;
use App\Repository\RecetteNegativeRepository;
use Doctrine\ORM\EntityManagerInterface;
use Symfony\Component\HttpFoundation\Request;
use Symfony\Component\HttpFoundation\Response;
use Symfony\Component\Routing\Annotation\Route;
use Symfony\Bundle\FrameworkBundle\Controller\AbstractController;
use Symfony\Component\HttpKernel\Exception\NotFoundHttpException;

class RecetteNegativeController extends AbstractController
{
    /**
     * @Route("/admin/recetteNegatives", name="admin_recetteNegatives", methods={"GET"})
     */
    public function listeRecetteNegatives(RecetteNegativeRepository $repo)
    {
        $recetteNegatives = $repo->findAll();
        return $this->render('admin/recetteNegative/listeRecetteNegatives.html.twig', [
            'lesRecetteNegatives' => $recetteNegatives
        ]);
    }

    /**
     * @Route("/admin/recetteNegative/ajout", name="admin_recetteNegative_ajout", methods={"GET","POST"})
     */
    public function ajoutRecetteNegative( Request $request, EntityManagerInterface $manager)
    {
        $recetteNegative=new RecetteNegative();
        $form=$this->createForm(RecetteNegativeType::class, $recetteNegative);
        $form->handleRequest($request);
        if($form->isSubmitted() && $form->isValid())
        {
            $manager->persist($recetteNegative);
            $manager->flush();
            $this->addFlash("success", "La recette a bien été ajoutée");
            return $this->redirectToRoute('admin_recetteNegatives');
        }
        return $this->render('admin/recetteNegative/formAjoutRecetteNegative.html.twig', [
            'formRecetteNegative' => $form->createView(),
            
        ]);
    }

    /**
    * @Route("/admin/recetteNegative/modif/{id}", name="admin_recetteNegative_modif", methods={"GET","POST"})
    */
    public function modifRecetteNegative($id, Request $request, EntityManagerInterface $manager, RecetteNegativeRepository $recetteNegativeRepository)
    {
        $recetteNegative = $recetteNegativeRepository->find($id);

        if (!$recetteNegative) {
            throw new NotFoundHttpException('Recette non trouvé');
        }

        // Créer le formulaire en utilisant la recette à modifier
        $form = $this->createForm(RecetteNegativeType::class, $recetteNegative);
        $form->handleRequest($request);

        if ($form->isSubmitted() && $form->isValid()) {
            // Vérifier si le champ nomRecette n'est pas vide
            if (!$recetteNegative->getNomRecetteNegative()) {
                $this->addFlash('error', 'Le nom de la recette est obligatoire.');
                return $this->redirectToRoute('admin_recetteNegative_modif', ['id' => $id]);
            }

            // Aucun besoin de persister la recette, elle est déjà enregistré dans la base de données
            $manager->flush();
        
            $this->addFlash("success", "La recette a bien été modifiée");
            return $this->redirectToRoute('admin_recetteNegatives');
        }

        return $this->render('admin/recetteNegative/formModifRecetteNegative.html.twig', [
            'formRecetteNegative' => $form->createView(),
            'recetteNegativeId' => $id, // Passer l'ID de la recette au template
        ]);
    }

    /**
     * @Route("/admin/recetteNegative/suppression/{id}", name="admin_recetteNegative_suppression", methods={"GET"})
     */
    public function suppressionRecetteNegative($id, EntityManagerInterface $manager): Response
    {
        $recetteNegative = $manager->getRepository(RecetteNegative::class)->find($id);
    
        if (!$recetteNegative) {
            throw new NotFoundHttpException('Recette non trouvé');
        }
    
        $manager->remove($recetteNegative);
        $manager->flush();
    
        $this->addFlash("success", "La recette a bien été supprimée");
        return $this->redirectToRoute('admin_recetteNegatives');
    }
    
}