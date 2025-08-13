<?php

namespace App\Controller;

use App\Entity\Serie;
use App\Repository\SerieRepository;
use Doctrine\ORM\EntityManagerInterface;
use Symfony\Bundle\FrameworkBundle\Controller\AbstractController;
use Symfony\Component\HttpFoundation\Response;
use Symfony\Component\Routing\Annotation\Route;

final class SerieController extends AbstractController
{

    #[Route('/serie/list', name: 'list', methods: ['GET'])]
    public function list(SerieRepository $serieRepository): Response
    {
        $series = $serieRepository->findAll();

        //dd($series);

        return $this->render('serie/list.html.twig', [
            'series' => $series
        ]);
    }
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
