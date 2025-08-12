<?php

namespace App\Controller;

use Symfony\Bundle\FrameworkBundle\Controller\AbstractController;
use Symfony\Component\HttpFoundation\Response;
use Symfony\Component\Routing\Attribute\Route;

#[Route('/livre', name:'livre')]
final class LivreController extends AbstractController
{
    #[Route('/liste', name: '_liste', methods: ['POST'])]
    public function list(): Response
    {
        return $this->render('livre/index.html.twig',);
    }

    #[Route('/edit', name: '_edit')]
    public function edit(): Response
    {
        return $this->render('livre/index.html.twig');
    }

    #[Route('/delete', name: '_delete')]
    public function delete(): Response
    {
        return $this->render('livre/index.html.twig');
    }
}
