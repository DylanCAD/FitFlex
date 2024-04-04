<?php

namespace App\Controller\Admin;

use App\Entity\Recette;
use App\Form\RecetteType;
use Doctrine\ORM\EntityManager;
use Doctrine\ORM\Mapping\Entity;
use App\Repository\RecetteRepository;
use Doctrine\ORM\EntityManagerInterface;
use Symfony\Component\HttpFoundation\Request;
use Symfony\Component\HttpFoundation\Response;
use Symfony\Component\Routing\Annotation\Route;
use Symfony\Bundle\FrameworkBundle\Controller\AbstractController;
use Symfony\Component\HttpKernel\Exception\NotFoundHttpException;

class RecetteController extends AbstractController
{
    /**
     * @Route("/admin/recettes", name="admin_recettes", methods={"GET"})
     */
    public function listeRecettes(RecetteRepository $repo)
    {
        $recettes = $repo->findAll();
        return $this->render('admin/recette/listeRecettes.html.twig', [
            'lesRecettes' => $recettes
        ]);
    }

    /**
     * @Route("/admin/recette/ajout", name="admin_recette_ajout", methods={"GET","POST"})
     */
    public function ajoutRecette( Request $request, EntityManagerInterface $manager)
    {
        $recette=new Recette();
        $form=$this->createForm(RecetteType::class, $recette);
        $form->handleRequest($request);
        if($form->isSubmitted() && $form->isValid())
        {
            $manager->persist($recette);
            $manager->flush();
            $this->addFlash("success", "La recette a bien été ajoutée");
            return $this->redirectToRoute('admin_recettes');
        }
        return $this->render('admin/recette/formAjoutRecette.html.twig', [
            'formRecette' => $form->createView(),
            
        ]);
    }

    /**
    * @Route("/admin/recette/modif/{id}", name="admin_recette_modif", methods={"GET","POST"})
    */
    public function modifRecette($id, Request $request, EntityManagerInterface $manager, RecetteRepository $recetteRepository)
    {
        $recette = $recetteRepository->find($id);

        if (!$recette) {
            throw new NotFoundHttpException('Recette non trouvé');
        }

        // Créer le formulaire en utilisant la recette à modifier
        $form = $this->createForm(RecetteType::class, $recette);
        $form->handleRequest($request);

        if ($form->isSubmitted() && $form->isValid()) {
            // Vérifier si le champ nomRecette n'est pas vide
            if (!$recette->getNomRecette()) {
                $this->addFlash('error', 'Le nom de la recette est obligatoire.');
                return $this->redirectToRoute('admin_recette_modif', ['id' => $id]);
            }

            // Aucun besoin de persister la recette, elle est déjà enregistré dans la base de données
            $manager->flush();
        
            $this->addFlash("success", "La recette a bien été modifiée");
            return $this->redirectToRoute('admin_recettes');
        }

        return $this->render('admin/recette/formModifRecette.html.twig', [
            'formRecette' => $form->createView(),
            'recetteId' => $id, // Passer l'ID de la recette au template
        ]);
    }

    /**
     * @Route("/admin/recette/suppression/{id}", name="admin_recette_suppression", methods={"GET"})
     */
    public function suppressionRecette($id, EntityManagerInterface $manager): Response
    {
        $recette = $manager->getRepository(Recette::class)->find($id);
    
        if (!$recette) {
            throw new NotFoundHttpException('Recette non trouvé');
        }
    
        $manager->remove($recette);
        $manager->flush();
    
        $this->addFlash("success", "La recette a bien été supprimée");
        return $this->redirectToRoute('admin_recettes');
    }
    
}