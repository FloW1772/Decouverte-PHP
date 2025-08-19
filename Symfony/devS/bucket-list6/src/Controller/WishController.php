<?php

namespace App\Controller;

use App\Entity\Wish;
use App\Form\WishType;
use App\Repository\WishRepository;
use Doctrine\ORM\EntityManagerInterface;
use Symfony\Bundle\FrameworkBundle\Controller\AbstractController;
use Symfony\Component\HttpFoundation\Request;
use Symfony\Component\HttpFoundation\Response;
use Symfony\Component\Routing\Annotation\Route;

#[Route('/wish')]
class WishController extends AbstractController
{
    #[Route('/', name: 'app_wish_index', methods: ['GET'])]
    public function index(WishRepository $wishRepository): Response
    {
        $wishes = $wishRepository->findAll();

        // Le template 'list.html.twig' correspond à ton arborescence
        return $this->render('wish/list.html.twig', [
            'wishes' => $wishes,
        ]);
    }

    #[Route('/new', name: 'app_wish_create', methods: ['GET', 'POST'])]
    public function create(Request $request, EntityManagerInterface $em): Response
    {
        $wish = new Wish();
        $form = $this->createForm(WishType::class, $wish);
        $form->handleRequest($request);

        if ($form->isSubmitted() && $form->isValid()) {
            $em->persist($wish);
            $em->flush();

            return $this->redirectToRoute('app_wish_index');
        }

        return $this->render('wish/create.html.twig', [
            'form' => $form->createView(),
        ]);
    }

    #[Route('/{id}/edit', name: 'app_wish_edit', methods: ['GET', 'POST'])]
    public function edit(Request $request, Wish $wish, EntityManagerInterface $em): Response
    {
        $form = $this->createForm(WishType::class, $wish);
        $form->handleRequest($request);

        if ($form->isSubmitted() && $form->isValid()) {
            $em->flush();

            return $this->redirectToRoute('app_wish_index');
        }

        return $this->render('wish/edit.html.twig', [
            'form' => $form->createView(),
            'wish' => $wish,
        ]);
    }
    #[Route('/{id}', name: 'app_wish_detail', methods: ['GET'])]
    public function detail(Wish $wish): Response
    {
        return $this->render('wish/detail.html.twig', [
            'wish' => $wish,
        ]);
    }


    #[Route('/{id}', name: 'app_wish_delete', methods: ['POST'])]
    public function delete(Request $request, Wish $wish, EntityManagerInterface $em): Response
    {
        if ($this->isCsrfTokenValid('delete'.$wish->getId(), $request->request->get('_token'))) {
            $em->remove($wish);
            $em->flush();
        }

        return $this->redirectToRoute('app_wish_index');
    }
}
