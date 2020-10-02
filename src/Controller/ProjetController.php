<?php

namespace App\Controller;

use App\Repository\ProjetsRepository;
use App\Repository\CompetencesRepository;
use Symfony\Component\Routing\Annotation\Route;
use Symfony\Bundle\FrameworkBundle\Controller\AbstractController;

class ProjetController extends AbstractController
{
    /**
     * @Route("/projet", name="projet")
     */
    public function index(ProjetsRepository $projetsRepository, CompetencesRepository $competencesRepository)
    {
       
       $projets = $projetsRepository->findAll();
       $competences = $competencesRepository->findAll();

        return $this->render('projet/projet.html.twig', [
            'projets' => $projets,
            'competences' => $competences,
        ]);
    }





}