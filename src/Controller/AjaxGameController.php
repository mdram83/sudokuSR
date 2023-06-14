<?php

namespace App\Controller;

use App\Entity\ActiveGame;
use App\Entity\FinishedGame;
use App\Entity\Sudoku;
use App\Repository\ActiveGameRepository;
use App\Repository\FinishedGameRepository;
use App\Repository\SudokuRepository;
use Symfony\Bundle\FrameworkBundle\Controller\AbstractController;
use Symfony\Component\HttpFoundation\Request;
use Symfony\Component\HttpFoundation\Response;
use Symfony\Component\HttpKernel\Exception\BadRequestHttpException;
use Symfony\Component\Routing\Annotation\Route;
use Symfony\Component\Validator\Validator\ValidatorInterface;

class AjaxGameController extends AbstractController
{
    private ValidatorInterface $validator;

    #[Route('/ajax/game/random', methods: ['GET'])]
    public function start(SudokuRepository $repository): Response
    {
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
        Request $request,
        ValidatorInterface $validator
    ): Response
    {
        $this->validator = $validator;
        $gameSet = json_decode($request->getContent(), true);
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

        $sudoku = $sudokuRepository->find($gameSet['sudokuId']);
        $activeGame = $this->setActiveGameParams($activeGame, $gameSet, $sudoku, $userId);

        $errors = $this->validator->validate($activeGame);
        if (count($errors) > 0) {
            $this->throwBadRequest();
        }

        $activeGameRepository->save($activeGame, true);

        return $activeGame;
    }

    private function setActiveGameParams(ActiveGame $activeGame, array $gameSet, Sudoku $sudoku, string $userId): ActiveGame
    {
        $activeGame->setAnonymousUser($userId);
        $activeGame->setSudoku($sudoku);

        $activeGame->setInitialBoard($gameSet['initialBoard']);
        $activeGame->setBoard($gameSet['board']);
        $activeGame->setBoardErrors($gameSet['boardErrors']);
        $activeGame->setNotes($gameSet['notes']);
        $activeGame->setNotesErrors($gameSet['notesErrors']);
        $activeGame->setEmptyCellsCount($gameSet['emptyCellsCount']);
        $activeGame->setDifficultyLevel($gameSet['difficultyLevel']);
        $activeGame->setTimer($gameSet['timerDuration']);

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
            $this->throwBadRequest();
        }
        return $userId;
    }

    private function throwBadRequest(string $message = '', int $code = 400): void
    {
        throw new BadRequestHttpException($message, null, 400);
    }
}