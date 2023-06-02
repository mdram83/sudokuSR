<?php

namespace App\Controller;

use App\Entity\ActiveGame;
use App\Repository\ActiveGameRepository;
use App\Repository\SudokuRepository;
use Symfony\Bundle\FrameworkBundle\Controller\AbstractController;
use Symfony\Component\HttpFoundation\Request;
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
    public function continue(ActiveGameRepository $repository, Request $request): Response
    {
        if (!$userId = $this->getAnonymousUserId($request)) {
            return $this->json(false, 400);
        }
        return $this->json($repository->findOneBy(['anonymousUser' => $userId]));
    }

    #[Route('/ajax/game/saveGame', methods: ['POST'])]
    public function saveGame(
        ActiveGameRepository $activeGameRepository,
        SudokuRepository $sudokuRepository,
        Request $request
    ): Response
    {
        $gameSet = json_decode($request->getContent(), true);
        // TODO validate inputs

        if (!$userId = $this->getAnonymousUserId($request)) {
            return $this->json(false, 400);
        }

        $this->saveActiveGame($activeGameRepository, $sudokuRepository, $gameSet, $userId);

        return $this->json(true);
    }

//    #[Route('/ajax/game/saveScore', methods: ['POST'])]
//    public function save(): Response
//    {
//        // TODO write logic to save Game
//        // TODO at the same time remove activeGame (saving score means active game is done, should not be continued)
//        return $this->json(true);
//    }

    private function saveActiveGame(
        ActiveGameRepository $activeGameRepository,
        SudokuRepository $sudokuRepository,
        array $gameSet,
        string $userId,
    ): ActiveGame
    {
        if (!($activeGame = $activeGameRepository->findOneBy(['anonymousUser' => $userId]))) {
            $activeGame = new ActiveGame();
        }

        $activeGame->setSudoku($sudokuRepository->find($gameSet['sudokuId']));
        $activeGame->setAnonymousUser($userId);

        $activeGame->setInitialBoard($gameSet['initialBoard']);
        $activeGame->setBoard($gameSet['board']);
        $activeGame->setBoardErrors($gameSet['boardErrors']);
        $activeGame->setNotes($gameSet['notes']);
        $activeGame->setNotesErrors($gameSet['notesErrors']);
        $activeGame->setEmptyCellsCount($gameSet['emptyCellsCount']);
        $activeGame->setDifficultyLevel($gameSet['difficultyLevel']);
        $activeGame->setTimer($gameSet['timerDuration']);

        $activeGameRepository->save($activeGame, true);

        return $activeGame;
    }

    private function getAnonymousUserId(Request $request): ?string
    {
        return $request->cookies->get($this->getParameter('app.anonymous_user_cookie.name'));
    }
}