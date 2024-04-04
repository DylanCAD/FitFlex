<?php

namespace App\Controller\Admin;

use App\Entity\Equipement;
use App\Form\EquipementType;
use Doctrine\ORM\EntityManager;
use Doctrine\ORM\Mapping\Entity;
use App\Repository\EquipementRepository;
use Doctrine\ORM\EntityManagerInterface;
use Symfony\Component\HttpFoundation\Request;
use Symfony\Component\HttpFoundation\Response;
use Symfony\Component\Routing\Annotation\Route;
use Symfony\Bundle\FrameworkBundle\Controller\AbstractController;
use Symfony\Component\HttpKernel\Exception\NotFoundHttpException;

class EquipementController extends AbstractController
{
    /**
     * @Route("/admin/equipements", name="admin_equipements", methods={"GET"})
     */
    public function listeEquipements(EquipementRepository $repo)
    {
        $equipements = $repo->findAll();
        return $this->render('admin/equipement/listeEquipements.html.twig', [
            'lesEquipements' => $equipements
        ]);
    }

    /**
     * @Route("/admin/equipement/ajout", name="admin_equipement_ajout", methods={"GET","POST"})
     */
    public function ajoutEquipement( Request $request, EntityManagerInterface $manager)
    {
        $equipement=new Equipement();
        $form=$this->createForm(EquipementType::class, $equipement);
        $form->handleRequest($request);
        if($form->isSubmitted() && $form->isValid())
        {
            $manager->persist($equipement);
            $manager->flush();
            $this->addFlash("success", "L'equipement a bien été ajouté");
            return $this->redirectToRoute('admin_equipements');
        }
        return $this->render('admin/equipement/formAjoutEquipement.html.twig', [
            'formEquipement' => $form->createView(),
            
        ]);
    }

    /**
    * @Route("/admin/equipement/modif/{id}", name="admin_equipement_modif", methods={"GET","POST"})
    */
    public function modifEquipement($id, Request $request, EntityManagerInterface $manager, EquipementRepository $equipementRepository)
    {
        $equipement = $equipementRepository->find($id);

        if (!$equipement) {
            throw new NotFoundHttpException('Equipement non trouvé');
        }

        // Créer le formulaire en utilisant l'équipement à modifier
        $form = $this->createForm(EquipementType::class, $equipement);
        $form->handleRequest($request);

        if ($form->isSubmitted() && $form->isValid()) {
            // Vérifier si le champ nomEquipement n'est pas vide
            if (!$equipement->getNomEquipement()) {
                $this->addFlash('error', 'Le nom de l\'équipement est obligatoire.');
                return $this->redirectToRoute('admin_equipement_modif', ['id' => $id]);
            }

            // Aucun besoin de persister l'équipement, il est déjà enregistré dans la base de données
            $manager->flush();
        
            $this->addFlash("success", "L'equipement a bien été modifié");
            return $this->redirectToRoute('admin_equipements');
        }

        return $this->render('admin/equipement/formModifEquipement.html.twig', [
            'formEquipement' => $form->createView(),
            'equipementId' => $id, // Passer l'ID de l'équipement au template
        ]);
    }

    /**
     * @Route("/admin/equipement/suppression/{id}", name="admin_equipement_suppression", methods={"GET"})
     */
    public function suppressionEquipement($id, EntityManagerInterface $manager): Response
    {
        $equipement = $manager->getRepository(Equipement::class)->find($id);
    
        if (!$equipement) {
            throw new NotFoundHttpException('Equipement non trouvé');
        }
    
        $manager->remove($equipement);
        $manager->flush();
    
        $this->addFlash("success", "L'équipement a bien été supprimé");
        return $this->redirectToRoute('admin_equipements');
    }
    
}