<?php

namespace App\Controller;

use App\Entity\Competences;
use App\Form\CompetenceType;
use App\Repository\CompetencesRepository;
use Symfony\Component\HttpFoundation\Request;
use Symfony\Component\Routing\Annotation\Route;
use Symfony\Bundle\FrameworkBundle\Controller\AbstractController;
use Symfony\Component\HttpFoundation\File\Exception\FileException;

class AdminCompetencesController extends AbstractController
{
    /**
     * @Route("/admin/competences", name="admin_competences")
     */
    public function index(CompetencesRepository $competencesRepository)
    {
        $competences = $competencesRepository->findAll();

        return $this->render('admin/adminCompetences.html.twig', [
            'competences' => $competences,
        ]);
    }

    /**
     * @Route("/admin/competences/create", name="competence_create")
     */
    public function createCompetence(Request $request)
    {
        $competence = new Competences();

        $form = $this->createForm(CompetenceType::class, $competence);
        $form->handleRequest($request);

        // récupèrer les informations du picto
        $picto = $form['picto']->getData();

        if ($form->isSubmitted()) {

            if ($form->isValid()) {

                $nomPicto = md5(uniqid()); // nom unique
                $extensionPicto = $picto->guessExtension(); // récupérer l'extension du picto
                $newNomPicto = $nomPicto . '.' . $extensionPicto; // recomposer un nom du picto

                try { // on tente d'importer l'image


                    $picto->move(
                        $this->getParameter('dossier_picto_competences'),
                        $newNomPicto
                    );
                } catch (FileException $e) {
                    $this->addFlash(
                        'danger',
                        'Une erreur est survenue lors de l\'importation du picto'
                    );
                }

                $competence->setPicto($newNomPicto); // nom pour la base de données

                $manager = $this->getDoctrine()->getManager();
                $manager->persist($competence);
                $manager->flush();
                $this->addFlash(
                    'success',
                    'La competence a bien été ajouté'
                );
            } else {
                $this->addFlash(
                    'danger',
                    'Une erreur est survenue'
                );
            }

            return $this->redirectToRoute('admin_competences');
        }

        return $this->render('admin/AdminCompetencesForm.html.twig', [
            'formulaireCompetence' => $form->createView()
        ]);
    }


    /**
     * @Route("/admin/competences/update-{id}", name="competence_update")
     */
    public function updateCompetence(CompetencesRepository $competencesRepository, $id, Request $request)
    {
        $competence = $competencesRepository->find($id);

        // récupérer nom et chemin picto
        $oldNomPicto = $competence->getPicto();
        $oldCheminPicto = $this->getParameter('dossier_picto_competences') . '/' . $oldNomPicto;


        $form = $this->createForm(CompetenceType::class, $competence);
        $form->handleRequest($request);
        // récupèrer les informations du picto
        $picto = $form['picto']->getData();

        if ($form->isSubmitted() && $form->isValid()) {

            // supprimer ancienne picto
            if ($oldNomPicto != null) {
                unlink($oldCheminPicto);
            }


            $nomPicto = md5(uniqid()); // nom unique
            $extensionPicto = $picto->guessExtension(); // récupérer l'extension du picto
            $newNomPicto = $nomPicto . '.' . $extensionPicto; // recomposer un nom du picto

            try { // on tente d'importer le picto                                      
                $picto->move(
                    $this->getParameter('dossier_picto_competences'),
                    $newNomPicto
                );
            } catch (FileException $e) {
                $this->addFlash(
                    'danger',
                    'Une erreur est survenue lors de l\'importation du picto'
                );
            }

            $competence->setPicto($newNomPicto); // nom pour la base de données


            $manager = $this->getDoctrine()->getManager();
            $manager->persist($competence);
            $manager->flush();
            $this->addFlash(
                'success',
                'Le competence a bien été modifié'
            );
            return $this->redirectToRoute('admin_competences');
        }

        return $this->render('admin/adminCompetencesForm.html.twig', [
            'formulaireCompetence' => $form->createView()
        ]);
    }

    /**
     * @Route("/admin/competences/delete-{id}", name="competence_delete")
     */
    public function deleteCompetence(CompetencesRepository $competencesRepository, $id)
    {
        $competence = $competencesRepository->find($id);
        // récupérer le nom et le chemin de l'image à supprimer
        $nomPicto = $competence->getPicto();
        $cheminPicto = $this->getParameter('dossier_picto_competences') . '/' . $nomPicto;

        // supprimer img1
        if ($nomPicto != null) {
            unlink($cheminPicto);
        }

        $manager = $this->getDoctrine()->getManager();
        $manager->remove($competence);
        $manager->flush();

        $this->addFlash(
            'danger',
            'Le competence a bien été supprimé'
        );

        return $this->redirectToRoute('admin_competences');
    }
}
