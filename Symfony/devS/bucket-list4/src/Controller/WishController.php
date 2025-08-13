<?php
namespace App\Controller;

use Symfony\Bundle\FrameworkBundle\Controller\AbstractController;
use Symfony\Component\HttpFoundation\Response;
use Symfony\Component\Routing\Annotation\Route;

class WishController extends AbstractController
{
    #[Route('/wishes', name: 'app_wish_list')]
    public function list(): Response
    {
        return $this->render('wish/list.html.twig');
    }

    #[Route('/wish/{id}', name: 'app_wish_detail')]
    public function detail(int $id): Response
    {
        return $this->render('wish/detail.html.twig', [
            'id' => $id
        ]);
    }
}
