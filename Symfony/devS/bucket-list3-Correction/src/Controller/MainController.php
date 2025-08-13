<?php
namespace App\Controller;

use Symfony\Bundle\FrameworkBundle\Controller\AbstractController;
use Symfony\Component\HttpFoundation\Response;
use Symfony\Component\Routing\Annotation\Route;

class MainController extends AbstractController
{
    #[Route('/', name: 'app_home')]
    public function home(): Response
    {
        return $this->render('main/home.html.twig');
    }

 #[Route('/about-us', name: 'main_about_us', methods: ['GET'])]
 public function about(): Response
 {
 return $this->render('main/about_us.html.twig');
 }
}
