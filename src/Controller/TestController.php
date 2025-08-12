<?php

namespace App\Controller;

use Symfony\Bundle\FrameworkBundle\Controller\AbstractController;
use Symfony\Component\HttpFoundation\Response;
use Symfony\Component\Routing\Annotation\Route;

final class TestController extends AbstractController
{
    #[Route('/bonjour', name: 'app_test')]
    public function toto(): Response
    {
        $varHTML = 'h1
        return $this->render('test/index.html.twig');
    }

    #[Route('/truc', name: 'app_truc')]
    public function truc(): Response
    {
        // return $this->render('test/truc.html.twig');
        return new Response('truc truc');
    }
}
