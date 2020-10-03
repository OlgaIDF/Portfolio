<?php

namespace App\Controller;

use App\Entity\Competences;
use App\Form\CompetenceType;
use App\Repository\CompetencesRepository;
use Symfony\Component\HttpFoundation\Request;
use Symfony\Component\Routing\Annotation\Route;
use Symfony\Bundle\FrameworkBundle\Controller\AbstractController;

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

        $form = $this->createForm(competenceType::class, $competence);
        $form->handleRequest($request);

        if ($form->isSubmitted()) {

            if ($form->isValid()) {
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
    public function updatecompetence(CompetencesRepository $competencesRepository, $id, Request $request)
    {
        $competence = $competencesRepository->find($id);

        $form = $this->createForm(CompetenceType::class, $competence);
        $form->handleRequest($request);

        if ($form->isSubmitted() && $form->isValid()) {
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
    public function deletecompetence(CompetencesRepository $competencesRepository, $id)
    {
        $competence = $competencesRepository->find($id);

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
