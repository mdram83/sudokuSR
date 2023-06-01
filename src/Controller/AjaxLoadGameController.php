<?php

namespace App\Controller;

use App\Repository\ActiveGameRepository;
use App\Repository\SudokuRepository;
use Symfony\Bundle\FrameworkBundle\Controller\AbstractController;
use Symfony\Component\HttpFoundation\Response;
use Symfony\Component\Routing\Annotation\Route;

class AjaxLoadGameController extends AbstractController
{
    #[Route('/ajax/game/random', methods: ['GET'])]
    public function start(SudokuRepository $repository): Response
    {
        return $this->json($repository->findOneRandom());
    }

    #[Route('/ajax/game/continue', methods: ['GET'])]
    public function continue(ActiveGameRepository $repository): Response
    {
        // TODO add logic to detect logged or anonymous user id
        return $this->json($repository->findOneBy(['anonymousUser' => '1']));
    }

    #[Route('/ajax/game/saveGame', methods: ['POST'])]
    public function saveGame(ActiveGameRepository $repository): Response
    {
        // TODO write logic to save Game
        return $this->json(true);
    }

//    #[Route('/ajax/game/saveScore', methods: ['POST'])]
//    public function save(): Response
//    {
//        // TODO write logic to save Game
//        return $this->json(true);
//    }
}