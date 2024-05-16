<?php

namespace App\Controller\Admin;

use Doctrine\ORM\Query;
use Doctrine\ORM\EntityManager;
use Doctrine\ORM\Mapping\Entity;
use App\Entity\ExerciceMusculation;
use App\Form\ExerciceMusculationType;
use Doctrine\ORM\EntityManagerInterface;
use App\Form\FiltreExerciceMusculationType;
use Symfony\Component\HttpFoundation\Request;
use Symfony\Component\HttpFoundation\Response;
use Symfony\Component\Routing\Annotation\Route;
use App\Repository\ExerciceMusculationRepository;
use Symfony\Bundle\FrameworkBundle\Controller\AbstractController;
use Symfony\Component\HttpKernel\Exception\NotFoundHttpException;

class ExerciceMusculationController extends AbstractController
{
    /**
     * @Route("/admin/exerciceMusculations", name="admin_exerciceMusculations", methods={"GET"})
     */
    public function listeExerciceMusculations(ExerciceMusculationRepository $repo, Request $request)
    {
        $nom=null;
        $formFiltreExerciceMusculation=$this->createForm(FiltreExerciceMusculationType::class);
        $formFiltreExerciceMusculation->handleRequest($request);
        if($formFiltreExerciceMusculation->isSubmitted() && $formFiltreExerciceMusculation->isValid()){
            // on récupère la saisie dans le formulaire du nom
            $nom=$formFiltreExerciceMusculation->get('nom')->getData();
        }
        $query = $repo->listeExerciceMusculationsComplete($nom);

        if ($query instanceof Query) {
            $exerciceMusculations = $query->getResult();
        } else {
            // Gérer le cas où la méthode ne renvoie pas un objet Query
            // Peut-être renvoyer une liste vide ou une autre valeur par défaut
            $exerciceMusculations = [];
        }        return $this->render('admin/exerciceMusculation/listeExerciceMusculations.html.twig', [
            'lesExerciceMusculations' => $exerciceMusculations,
            'formFiltreExerciceMusculation'=>$formFiltreExerciceMusculation->createView()
        ]);
    }

    /**
     * @Route("/admin/exerciceMusculation/ajout", name="admin_exerciceMusculation_ajout", methods={"GET","POST"})
     */
    public function ajoutExerciceMusculation( Request $request, EntityManagerInterface $manager)
    {
        $exerciceMusculation=new ExerciceMusculation();
        $form=$this->createForm(ExerciceMusculationType::class, $exerciceMusculation);
        $form->handleRequest($request);
        if($form->isSubmitted() && $form->isValid())
        {
            // On récupère l'image sélectionnée
            $fichierImage = $form->get('imageFile')->getData();
            if ($fichierImage != null) {
                // On récupère le nom de l'image existante
                $ancienNomImage = $exerciceMusculation->getImageExerciceMusculation();
                // On construit le chemin complet du fichier existant
                $cheminImageExistante = $this->getParameter('imagesExercicemusculationsDestination') . $ancienNomImage;
                // On vérifie si l'image existante est un fichier
                if (file_exists($cheminImageExistante) && is_file($cheminImageExistante)) {
                    // On supprime l'ancien fichier
                    unlink($cheminImageExistante);
                }
                // On crée le nom du nouveau fichier
                $nouveauNomImage = 'image/exercicemusculation/' . md5(uniqid()) . "." . $fichierImage->guessExtension();
                // On déplace le fichier chargé dans le dossier public
                $fichierImage->move($this->getParameter('imagesExercicemusculationsDestination'), $nouveauNomImage);
                $exerciceMusculation->setImageExerciceMusculation($nouveauNomImage);
            }
            $manager->persist($exerciceMusculation);
            $manager->flush();
            $this->addFlash("success", "Le groupe musculaire a bien été ajouté");
            return $this->redirectToRoute('admin_exerciceMusculations');
        }
        return $this->render('admin/exerciceMusculation/formAjoutExerciceMusculation.html.twig', [
            'formExerciceMusculation' => $form->createView(),
            
        ]);
    }

    /**
    * @Route("/admin/exerciceMusculation/modif/{id}", name="admin_exerciceMusculation_modif", methods={"GET","POST"})
    */
    public function modifExerciceMusculation($id, Request $request, EntityManagerInterface $manager, ExerciceMusculationRepository $exerciceMusculationRepository)
    {
        $exerciceMusculation = $exerciceMusculationRepository->find($id);

        if (!$exerciceMusculation) {
            throw new NotFoundHttpException('Groupe musculaire non trouvé');
        }

        // Créer le formulaire en utilisant l'exercice à modifier
        $form = $this->createForm(ExerciceMusculationType::class, $exerciceMusculation);
        $form->handleRequest($request);

        if ($form->isSubmitted() && $form->isValid()) 
        {
            // On récupère l'image sélectionnée
            $fichierImage = $form->get('imageFile')->getData();
            if ($fichierImage != null) {
                // On récupère le nom de l'image existante
                $ancienNomImage = $exerciceMusculation->getImageExerciceMusculation();
                // On construit le chemin complet du fichier existant
                $cheminImageExistante = $this->getParameter('imagesExercicemusculationsDestination') . $ancienNomImage;
                // On vérifie si l'image existante est un fichier
                if (file_exists($cheminImageExistante) && is_file($cheminImageExistante)) {
                    // On supprime l'ancien fichier
                    unlink($cheminImageExistante);
                }
                // On crée le nom du nouveau fichier
                $nouveauNomImage = 'image/exercicemusculation/' . md5(uniqid()) . "." . $fichierImage->guessExtension();
                // On déplace le fichier chargé dans le dossier public
                $fichierImage->move($this->getParameter('imagesExercicemusculationsDestination'), $nouveauNomImage);
                $exerciceMusculation->setImageExerciceMusculation($nouveauNomImage);
            }
            // Vérifier si le champ nomExerciceMusculation n'est pas vide
            if (!$exerciceMusculation->getNomExerciceMusculation()) {
                $this->addFlash('error', 'Le nom du groupe musculaire est obligatoire.');
                return $this->redirectToRoute('admin_exerciceMusculation_modif', ['id' => $id]);
            }

            // Aucun besoin de persister l'exercice, il est déjà enregistré dans la base de données
            $manager->flush();
        
            $this->addFlash("success", "Le groupe musculaire a bien été modifié");
            return $this->redirectToRoute('admin_exerciceMusculations');
        }

        return $this->render('admin/exerciceMusculation/formModifExerciceMusculation.html.twig', [
            'formExerciceMusculation' => $form->createView(),
            'exerciceMusculationId' => $id, // Passer l'ID de l'exercice au template
        ]);
    }

    /**
     * @Route("/admin/exerciceMusculation/suppression/{id}", name="admin_exerciceMusculation_suppression", methods={"GET"})
     */
    public function suppressionExerciceMusculation($id, EntityManagerInterface $manager): Response
    {
        $exerciceMusculation = $manager->getRepository(ExerciceMusculation::class)->find($id);
    
        if (!$exerciceMusculation) {
            throw new NotFoundHttpException('Groupe musculaire non trouvé');
        }
    
        $manager->remove($exerciceMusculation);
        $manager->flush();
    
        $this->addFlash("success", "Le groupe musculaire a bien été supprimé");
        return $this->redirectToRoute('admin_exerciceMusculations');
    }
    
}