<?php

namespace App\Controller\Admin;

use Doctrine\ORM\Query;
use Doctrine\ORM\EntityManager;
use Doctrine\ORM\Mapping\Entity;
use App\Entity\TypeExerciceMusculation;
use Doctrine\ORM\EntityManagerInterface;
use App\Form\TypeExerciceMusculationType;
use Symfony\Component\HttpFoundation\Request;
use Symfony\Component\HttpFoundation\Response;
use App\Form\FiltreTypeExerciceMusculationType;
use Symfony\Component\Routing\Annotation\Route;
use App\Repository\TypeExerciceMusculationRepository;
use Symfony\Bundle\FrameworkBundle\Controller\AbstractController;
use Symfony\Component\HttpKernel\Exception\NotFoundHttpException;

class TypeExerciceMusculationController extends AbstractController
{
    /**
     * @Route("/admin/typeExerciceMusculations", name="admin_typeExerciceMusculations", methods={"GET"})
     */
    public function listeTypeExerciceMusculations(TypeExerciceMusculationRepository $repo, Request $request)
    {
        $nom=null;
        $formFiltreTypeExerciceMusculation=$this->createForm(FiltreTypeExerciceMusculationType::class);
        $formFiltreTypeExerciceMusculation->handleRequest($request);
        if($formFiltreTypeExerciceMusculation->isSubmitted() && $formFiltreTypeExerciceMusculation->isValid()){
            // on récupère la saisie dans le formulaire du nom
            $nom=$formFiltreTypeExerciceMusculation->get('nom')->getData();
        }
        $query = $repo->listeTypeExerciceMusculationsComplete($nom);

        if ($query instanceof Query) {
            $typeExerciceMusculations = $query->getResult();
        } else {
            // Gérer le cas où la méthode ne renvoie pas un objet Query
            // Peut-être renvoyer une liste vide ou une autre valeur par défaut
            $typeExerciceMusculations = [];
        }        return $this->render('admin/typeExerciceMusculation/listeTypeExerciceMusculations.html.twig', [
            'lesTypeExerciceMusculations' => $typeExerciceMusculations,
            'formFiltreTypeExerciceMusculation'=>$formFiltreTypeExerciceMusculation->createView()
        ]);
    }

    /**
     * @Route("/admin/typeExerciceMusculation/ajout", name="admin_typeExerciceMusculation_ajout", methods={"GET","POST"})
     */
    public function ajoutTypeExerciceMusculation( Request $request, EntityManagerInterface $manager)
    {
        $typeExerciceMusculation=new TypeExerciceMusculation();
        $form=$this->createForm(TypeExerciceMusculationType::class, $typeExerciceMusculation);
        $form->handleRequest($request);
        if($form->isSubmitted() && $form->isValid())
        {
            // On récupère l'image sélectionnée
            $fichierImage = $form->get('imageFile')->getData();
            if ($fichierImage != null) {
                // On récupère le nom de l'image existante
                $ancienNomImage = $typeExerciceMusculation->getImageTypeExerciceMusculation();
                // On construit le chemin complet du fichier existant
                $cheminImageExistante = $this->getParameter('imagesTypeExercicemusculationsDestination') . $ancienNomImage;
                // On vérifie si l'image existante est un fichier
                if (file_exists($cheminImageExistante) && is_file($cheminImageExistante)) {
                    // On supprime l'ancien fichier
                    unlink($cheminImageExistante);
                }
                // On crée le nom du nouveau fichier
                $nouveauNomImage = 'image/typeexercicemusculation/' . md5(uniqid()) . "." . $fichierImage->guessExtension();
                // On déplace le fichier chargé dans le dossier public
                $fichierImage->move($this->getParameter('imagesTypeExercicemusculationsDestination'), $nouveauNomImage);
                $typeExerciceMusculation->setImageTypeExerciceMusculation($nouveauNomImage);
            }
            $manager->persist($typeExerciceMusculation);
            $manager->flush();
            $this->addFlash("success", "L'exercice de musculation a bien été ajouté");
            return $this->redirectToRoute('admin_typeExerciceMusculations');
        }
        return $this->render('admin/typeExerciceMusculation/formAjoutTypeExerciceMusculation.html.twig', [
            'formTypeExerciceMusculation' => $form->createView(),
            
        ]);
    }

    /**
    * @Route("/admin/typeExerciceMusculation/modif/{id}", name="admin_typeExerciceMusculation_modif", methods={"GET","POST"})
    */
    public function modifTypeExerciceMusculation($id, Request $request, EntityManagerInterface $manager, TypeExerciceMusculationRepository $typeExerciceMusculationRepository)
    {
        $typeExerciceMusculation = $typeExerciceMusculationRepository->find($id);

        if (!$typeExerciceMusculation) {
            throw new NotFoundHttpException('Exercice de musculation non trouvé');
        }

        // Créer le formulaire en utilisant l'exercice à modifier
        $form = $this->createForm(TypeExerciceMusculationType::class, $typeExerciceMusculation);
        $form->handleRequest($request);

        if ($form->isSubmitted() && $form->isValid()) 
        {
            // On récupère l'image sélectionnée
            $fichierImage = $form->get('imageFile')->getData();
            if ($fichierImage != null) {
                // On récupère le nom de l'image existante
                $ancienNomImage = $typeExerciceMusculation->getImageTypeExerciceMusculation();
                // On construit le chemin complet du fichier existant
                $cheminImageExistante = $this->getParameter('imagesTypeExercicemusculationsDestination') . $ancienNomImage;
                // On vérifie si l'image existante est un fichier
                if (file_exists($cheminImageExistante) && is_file($cheminImageExistante)) {
                    // On supprime l'ancien fichier
                    unlink($cheminImageExistante);
                }
                // On crée le nom du nouveau fichier
                $nouveauNomImage = 'image/typeexercicemusculation/' . md5(uniqid()) . "." . $fichierImage->guessExtension();
                // On déplace le fichier chargé dans le dossier public
                $fichierImage->move($this->getParameter('imagesTypeExercicemusculationsDestination'), $nouveauNomImage);
                $typeExerciceMusculation->setImageTypeExerciceMusculation($nouveauNomImage);
            }
            // Vérifier si le champ nomExerciceMusculation n'est pas vide
            if (!$typeExerciceMusculation->getNomTypeExerciceMusculation()) {
                $this->addFlash('error', 'Le nom de l exercice de musculation est obligatoire.');
                return $this->redirectToRoute('admin_typeExerciceMusculation_modif', ['id' => $id]);
            }

            // Aucun besoin de persister l'exercice, il est déjà enregistré dans la base de données
            $manager->flush();
        
            $this->addFlash("success", "L'exercice de musculation a bien été modifié");
            return $this->redirectToRoute('admin_typeExerciceMusculations');
        }

        return $this->render('admin/typeExerciceMusculation/formModifTypeExerciceMusculation.html.twig', [
            'formTypeExerciceMusculation' => $form->createView(),
            'typeExerciceMusculationId' => $id, // Passer l'ID de l'exercice au template
        ]);
    }

    /**
     * @Route("/admin/typeExerciceMusculation/suppression/{id}", name="admin_typeExerciceMusculation_suppression", methods={"GET"})
     */
    public function suppressionTypeExerciceMusculation($id, EntityManagerInterface $manager): Response
    {
        $typeExerciceMusculation = $manager->getRepository(TypeExerciceMusculation::class)->find($id);
    
        if (!$typeExerciceMusculation) {
            throw new NotFoundHttpException('Exercice musculation non trouvé');
        }
    
        $manager->remove($typeExerciceMusculation);
        $manager->flush();
    
        $this->addFlash("success", "L'exercice de musculation a bien été supprimé");
        return $this->redirectToRoute('admin_typeExerciceMusculations');
    }
    
}