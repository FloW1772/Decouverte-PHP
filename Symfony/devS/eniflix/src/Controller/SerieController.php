<?php

namespace App\Controller;

use App\Repository\SerieRepository;
use Symfony\Bundle\FrameworkBundle\Controller\AbstractController;
use Symfony\Component\HttpFoundation\Response;
use Symfony\Component\Routing\Attribute\Route;

#[Route('/serie', name: 'serie')]
final class SerieController extends AbstractController
{

    #[Route('/list', name: '_list', methods: ['GET'])]
    public function list(SerieRepository $serieRepository, int $page): Response
    {
        //$series = $serieRepository->findAll();

        $series = $serieRepository->findBy(
            [
                'status' => 'Returning',
                'genre'  => 'Drama',
            ],
            [
                'popularity' => 'DESC',
            ],
            limit: 10,
            offset: 0

        );


        return $this->render('serie/list.html.twig', [
            'series' => $series
        ]);
    }

    #[Route('/detail/{id}', name: '_detail')]
    public function detail(int $id, SerieRepository $serieRepository): Response
    {
        $serie = $serieRepository->find($id);

        if (!$serie) {
            throw $this->createNotFoundException('Pas de série pour cet id');
        }

        return $this->render('serie/detail.html.twig', [
            'serie' => $serie
        ]);
        //  #[Route('/serie', name: 'app_serie')]
        //  public function index(EntityManagerInterface $em): Response
        //{
        //  $serie = new Serie();
        //  $serie->setName('One piece')
        //      ->setStatus('Returning')
        //      ->setGenre('Anime')
        //      ->setFirstAirDate(new \DateTime('1999-10-20'))
        //      ->setDateCreated(new \DateTime());

        //  $em->persist($serie);
        //  $em->flush();



        //  return new Response('Une série a été créée');
        //}
    }

}