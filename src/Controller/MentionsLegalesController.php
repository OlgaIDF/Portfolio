<?php

namespace App\Controller;

use Symfony\Bundle\FrameworkBundle\Controller\AbstractController;
use Symfony\Component\HttpFoundation\Response;
use Symfony\Component\Routing\Annotation\Route;

class MentionsLegalesController extends AbstractController
{
    /**
     * @Route("/mentions_legales", name="mentions_legales")
     */
    public function index(): Response
    {
        return $this->render('mentions_legales.html.twig');
    }
}
