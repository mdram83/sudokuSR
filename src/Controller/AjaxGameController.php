<?php

namespace App\Controller;

use App\Entity\ActiveGame;
use App\Entity\FinishedGame;
use App\Entity\Sudoku;
use App\Entity\User;
use App\Repository\ActiveGameRepository;
use App\Repository\FinishedGameRepository;
use App\Repository\SudokuRepository;
use App\Repository\UserRepository;
use Exception;
use Symfony\Bundle\FrameworkBundle\Controller\AbstractController;
use Symfony\Component\HttpFoundation\Request;
use Symfony\Component\HttpFoundation\Response;
use Symfony\Component\HttpKernel\Exception\BadRequestHttpException;
use Symfony\Component\Routing\Annotation\Route;
use Symfony\Component\Validator\Validator\ValidatorInterface;

class AjaxGameController extends AbstractController
{
    #[Route('/ajax/game/random', methods: ['GET'])]
    public function start(SudokuRepository $sudokuRepository): Response
    {
        return $this->json($sudokuRepository->findOneRandom());
    }

    #[Route('/ajax/game/continue', methods: ['GET'])]
    public function continue(ActiveGameRepository $activeGameRepository): Response
    {
        return $this->json($this->getUserActiveGame($activeGameRepository));
    }

    #[Route('/ajax/game/saveGame', methods: ['POST'])]
    public function saveGame(
        ActiveGameRepository $activeGameRepository,
        SudokuRepository $sudokuRepository,
        Request $request,
        ValidatorInterface $validator
    ): Response
    {
        $gameSet = json_decode($request->getContent(), true);
        $activeGame = $this->getUserActiveGame($activeGameRepository) ?? new ActiveGame();

        $this->setActiveGameParams(
            $activeGame,
            $gameSet,
            $sudokuRepository->find($gameSet['sudokuId']),
            $this->getAnonymousUserId(),
            $this->getUser()
        );

        $this->validateActiveGameOrBadRequest($activeGame, $validator);
        $activeGameRepository->save($activeGame, true);

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
        $this->saveFinishedGame(
            $finishedGameRepository,
            $sudokuRepository,
            json_decode($request->getContent(), true),
            $this->getAnonymousUserId()
        );

        if ($activeGame = $this->getUserActiveGame($activeGameRepository)) {
            $activeGameRepository->remove($activeGame, true);
        }

        return $this->json(true);
    }

    private function setActiveGameParams(
        ActiveGame $activeGame,
        array $gameSet,
        Sudoku $sudoku,
        string $userId,
        ?User $activeUser
    ): void
    {
        $activeGame->setAnonymousUser($userId);
        $activeGame->setActiveUser($activeUser);
        $activeGame->setSudoku($sudoku);

        $activeGame->setInitialBoard($gameSet['initialBoard']);
        $activeGame->setBoard($gameSet['board']);
        $activeGame->setBoardErrors($gameSet['boardErrors']);
        $activeGame->setNotes($gameSet['notes']);
        $activeGame->setNotesErrors($gameSet['notesErrors']);
        $activeGame->setEmptyCellsCount($gameSet['emptyCellsCount']);
        $activeGame->setDifficultyLevel($gameSet['difficultyLevel']);
        $activeGame->setTimer($gameSet['timerDuration']);
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

    private function getUserActiveGame(ActiveGameRepository $activeGameRepository): ?ActiveGame
    {
        $activeUser = $this->getUser();
        $userId = $this->getAnonymousUserId();

        return $activeGameRepository->findOneBy(
            isset($activeUser) ? ['activeUser' => $activeUser] : ['anonymousUser' => $userId]
        );
    }

    private function getAnonymousUserId(): ?string
    {
        if (!$userId = Request::createFromGlobals()->cookies->get($this->getParameter('app.anonymous_user_cookie.name'))) {
            $this->throwBadRequest();
        }
        return $userId;
    }

    private function throwBadRequest(string $message = '', int $code = 400): void
    {
        throw new BadRequestHttpException($message, null, 400);
    }

    private function validateActiveGameOrBadRequest(ActiveGame $activeGame, ValidatorInterface $validator): void
    {
        $errors = $validator->validate($activeGame);

        if (count($errors) > 0) {
            $this->throwBadRequest();
        }
    }
}