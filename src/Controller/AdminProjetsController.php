<?php

namespace App\Controller;

use App\Entity\Projets;
use App\Form\ProjetType;
use App\Repository\ProjetsRepository;
use Symfony\Component\HttpFoundation\Request;
use Symfony\Component\Routing\Annotation\Route;
use Symfony\Bundle\FrameworkBundle\Controller\AbstractController;

class AdminProjetsController extends AbstractController
{
    /**
     * @Route("/admin/projets", name="admin_projets")
     */
    public function index(ProjetsRepository $projetsRepository)
    {
        $projets = $projetsRepository->findAll();

        return $this->render('admin/adminProjets.html.twig', [
            'projets' => $projets,
        ]);
    }

    /**
     * @Route("/admin/projets/create", name="projet_create")
     */
    public function createProjet(Request $request)
    {
        $projet = new Projets();

        $form = $this->createForm(ProjetType::class, $projet);
        $form->handleRequest($request);

        if ($form->isSubmitted()) {

            if ($form->isValid()) {
                $manager = $this->getDoctrine()->getManager();
                $manager->persist($projet);
                $manager->flush();
                $this->addFlash(
                    'success',
                    'La projet a bien été ajouté'
                );
            } else {
                $this->addFlash(
                    'danger',
                    'Une erreur est survenue'
                );
            }

            return $this->redirectToRoute('admin_projets');
        }

        return $this->render('admin/adminProjetForm.html.twig', [
            'formulaireProjet' => $form->createView()
        ]);
    }

    /**
     * @Route("/admin/projets/update-{id}", name="projet_update")
     */
    public function updateprojet(ProjetsRepository $projetsRepository, $id, Request $request)
    {
        $projet = $projetsRepository->find($id);

        $form = $this->createForm(ProjetType::class, $projet);
        $form->handleRequest($request);

        if ($form->isSubmitted() && $form->isValid()) {
            $manager = $this->getDoctrine()->getManager();
            $manager->persist($projet);
            $manager->flush();
            $this->addFlash(
                'success',
                'Le projet a bien été modifié'
            );
            return $this->redirectToRoute('admin_projets');
        }

        return $this->render('admin/adminProjetForm.html.twig', [
            'formulaireProjet' => $form->createView()
        ]);
    }

    /**
     * @Route("/admin/projets/delete-{id}", name="projet_delete")
     */
    public function deleteProjet(ProjetsRepository $projetsRepository, $id)
    {
        $projet = $projetsRepository->find($id);

        $manager = $this->getDoctrine()->getManager();
        $manager->remove($projet);
        $manager->flush();

        $this->addFlash(
            'danger',
            'Le projet a bien été supprimé'
        );

        return $this->redirectToRoute('admin_projets');
    }
}
