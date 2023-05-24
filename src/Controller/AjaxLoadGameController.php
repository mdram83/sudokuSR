<?php

namespace App\Controller;

use App\Repository\SudokuRepository;
use Symfony\Bundle\FrameworkBundle\Controller\AbstractController;
use Symfony\Component\HttpFoundation\Response;
use Symfony\Component\Routing\Annotation\Route;

class AjaxLoadGameController extends AbstractController
{
    #[Route('/ajax/game/random', methods: ['GET'])]
    public function random(SudokuRepository $repository): Response
    {
        return $this->json($repository->findOneRandom());
    }
}