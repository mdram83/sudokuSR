<?php

namespace App\Controller;

use App\Entity\ActiveGame;
use App\Entity\FinishedGame;
use App\Repository\ActiveGameRepository;
use App\Repository\FinishedGameRepository;
use App\Repository\SudokuRepository;
use Symfony\Bundle\FrameworkBundle\Controller\AbstractController;
use Symfony\Component\HttpFoundation\Request;
use Symfony\Component\HttpFoundation\Response;
use Symfony\Component\HttpKernel\Exception\BadRequestHttpException;
use Symfony\Component\Routing\Annotation\Route;

class AjaxGameController extends AbstractController
{
    #[Route('/ajax/game/random', methods: ['GET'])]
    public function start(SudokuRepository $repository): Response
    {
        // TODO this query not working when indexes in sudoku are not in order, FIX IT!
        return $this->json($repository->findOneRandom());
    }

    #[Route('/ajax/game/continue', methods: ['GET'])]
    public function continue(ActiveGameRepository $repository, Request $request): Response
    {
        return $this->json($repository->findOneBy(['anonymousUser' => $this->getAnonymousUserId($request)]));
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

        $this->saveActiveGame($activeGameRepository, $sudokuRepository, $gameSet, $this->getAnonymousUserId($request));

        return $this->json(true);
    }

    #[Route('/ajax/game/saveScore', methods: ['POST'])]
    public function saveScore(
        ActiveGameRepository $activeGameRepository,
        FinishedGameRepository $finishedGameRepository,
        SudokuRepository $sudokuRepository,
        Request $request
    ): Response
    {
        $gameSet = json_decode($request->getContent(), true);
        // TODO validate inputs

        $userId = $this->getAnonymousUserId($request);

        $this->saveFinishedGame($finishedGameRepository, $sudokuRepository, $gameSet, $userId);

        if ($activeGame = $activeGameRepository->findOneBy(['anonymousUser' => $userId])) {
            $activeGameRepository->remove($activeGame, true);
        }

        return $this->json(true);
    }

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

    private function saveFinishedGame(
        FinishedGameRepository $finishedGameRepository,
        SudokuRepository $sudokuRepository,
        array $gameSet,
        string $userId,
    ): FinishedGame
    {

        $sudoku = $sudokuRepository->find($gameSet['sudokuId']);

        if ($game = $finishedGameRepository->findOneBy(['sudoku' => $sudoku, 'anonymousUser' => $userId])) {
            return $game;
        }

        $game = new FinishedGame();

        $game->setSudoku($sudoku);
        $game->setAnonymousUser($userId);
        $game->setTimer($gameSet['timerDuration']);
        $game->setFinishedAt(new \DateTimeImmutable('now'));

        $finishedGameRepository->save($game, true);

        return $game;
    }

    private function getAnonymousUserId(Request $request): ?string
    {
        if (!$userId = $request->cookies->get($this->getParameter('app.anonymous_user_cookie.name'))) {
            throw new BadRequestHttpException('', null, 400);
        }
        return $userId;
    }
}