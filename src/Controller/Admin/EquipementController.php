<?php

namespace App\Controller\Admin;

use Doctrine\ORM\Query;
use App\Entity\Equipement;
use App\Form\EquipementType;
use Doctrine\ORM\EntityManager;
use Doctrine\ORM\Mapping\Entity;
use App\Form\FiltreEquipementType;
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
    public function listeEquipements(EquipementRepository $repo, Request $request)
    {
        $nom=null;
        $formFiltreEquipement=$this->createForm(FiltreEquipementType::class);
        $formFiltreEquipement->handleRequest($request);
        if($formFiltreEquipement->isSubmitted() && $formFiltreEquipement->isValid()){
            // on récupère la saisie dans le formulaire du nom
            $nom=$formFiltreEquipement->get('nom')->getData();
        }
        $query = $repo->listeEquipementsComplete($nom);

        if ($query instanceof Query) {
            $equipements = $query->getResult();
        } else {
            // Gérer le cas où la méthode ne renvoie pas un objet Query
            // Peut-être renvoyer une liste vide ou une autre valeur par défaut
            $equipements = [];
        }        return $this->render('admin/equipement/listeEquipements.html.twig', [
            'lesEquipements' => $equipements,
            'formFiltreEquipement'=>$formFiltreEquipement->createView()
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
            // On récupère l'image sélectionnée
            $fichierImage = $form->get('imageFile')->getData();
            if ($fichierImage != null) {
                // On récupère le nom de l'image existante
                $ancienNomImage = $equipement->getImageEquipement();
                // On construit le chemin complet du fichier existant
                $cheminImageExistante = $this->getParameter('imagesEquipementsDestination') . $ancienNomImage;
                // On vérifie si l'image existante est un fichier
                if (file_exists($cheminImageExistante) && is_file($cheminImageExistante)) {
                    // On supprime l'ancien fichier
                    unlink($cheminImageExistante);
                }
                // On crée le nom du nouveau fichier
                $nouveauNomImage = 'image/equipement/' . md5(uniqid()) . "." . $fichierImage->guessExtension();
                // On déplace le fichier chargé dans le dossier public
                $fichierImage->move($this->getParameter('imagesEquipementsDestination'), $nouveauNomImage);
                $equipement->setImageEquipement($nouveauNomImage);
            }
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

        if ($form->isSubmitted() && $form->isValid()) 
        {
            // On récupère l'image sélectionnée
            $fichierImage = $form->get('imageFile')->getData();
            if ($fichierImage != null) {
                // On récupère le nom de l'image existante
                $ancienNomImage = $equipement->getImageEquipement();
                // On construit le chemin complet du fichier existant
                $cheminImageExistante = $this->getParameter('imagesEquipementsDestination') . $ancienNomImage;
                // On vérifie si l'image existante est un fichier
                if (file_exists($cheminImageExistante) && is_file($cheminImageExistante)) {
                    // On supprime l'ancien fichier
                    unlink($cheminImageExistante);
                }
                // On crée le nom du nouveau fichier
                $nouveauNomImage = 'image/equipement/' . md5(uniqid()) . "." . $fichierImage->guessExtension();
                // On déplace le fichier chargé dans le dossier public
                $fichierImage->move($this->getParameter('imagesEquipementsDestination'), $nouveauNomImage);
                $equipement->setImageEquipement($nouveauNomImage);
            }
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