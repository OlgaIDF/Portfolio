<?php

namespace App\Controller;

use Symfony\Component\HttpFoundation\Request;
use Symfony\Component\Routing\Annotation\Route;
use Symfony\Bundle\FrameworkBundle\Controller\AbstractController;

class TranslationController extends AbstractController
{
    /**
     * @Route("/change-locale/{locale}", name="change-locale")
     */
    public function changeLocale($locale, Request $request )
    {
        $request -> getSession() ->set('_locale', $locale);

        return $this->redirect($request->headers->get('referer'));
       
    }
}
