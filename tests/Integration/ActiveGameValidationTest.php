<?php

namespace App\Tests\Integration;

use App\Entity\ActiveGame;
use Symfony\Bundle\FrameworkBundle\Test\KernelTestCase;
use Symfony\Component\Validator\Validator\ValidatorInterface;

final class ActiveGameValidationTest extends KernelTestCase
{
    private array $boardRowCorrect   = [4, null, 6, 7, null, null, null, 5, null];
    private array $boardRowIncorrect = [4, null, 6, 7, null, null, null, 5,    0];
    private array $boardErrorsRowCorrect   = [false, false, false, false, false, false, false, false, true];
    private array $boardErrorsRowIncorrect = [false, false, false, false, false, false, false, false, null];
    private array $notesRowCorrect = [1, 2, 3, 4, 5, 6, null, '',  '9'];
    private array $notesRowIncorrect = [1, 2, 3, 4, 5, 6, null, '',    0];

    private array $board;
    private array $initialBoard;
    private array $boardErrors;
    private array $notes;

    private ValidatorInterface $validator;
    private ActiveGame $activeGame;

    final public function setUp(): void
    {
        self::bootKernel();
        $container = self::getContainer();
        $this->validator = $container->get(ValidatorInterface::class);
        $this->activeGame = new ActiveGame();
    }

    private function configureActiveGame(
        array $boardRow,
        array $initialBoard,
        array $boardErrorsRow,
        array $notesRow
    ): void
    {
        $this->board = array_fill(0, 9, $boardRow);
        $this->initialBoard = array_fill(0, 9, $initialBoard);
        $this->boardErrors = array_fill(0, 9, $boardErrorsRow);
        $this->notes = array_fill(0, 9, array_fill(0, 9, $notesRow));

        $this->populateValues();
    }

    private function populateValues(): void
    {
        $this->activeGame->setBoard($this->board);
        $this->activeGame->setInitialBoard($this->initialBoard);
        $this->activeGame->setBoardErrors($this->boardErrors);
        $this->activeGame->setNotes($this->notes);
    }

    public function testCorrectBoardNoErrors(): void
    {
        $this->configureActiveGame(
            $this->boardRowCorrect,
            $this->boardRowCorrect,
            $this->boardErrorsRowCorrect,
            $this->notesRowCorrect
        );

        $errors = $this->validator->validate($this->activeGame);
        $this->assertCount(0, $errors);
    }

    public function testIncorrectBoardHasError(): void
    {
        $this->configureActiveGame(
            $this->boardRowIncorrect,
            $this->boardRowCorrect,
            $this->boardErrorsRowCorrect,
            $this->notesRowCorrect
        );

        $errors = $this->validator->validate($this->activeGame);
        $this->assertCount(1, $errors);
    }

    public function testIncorrectInitialBoardHasError(): void
    {
        $this->configureActiveGame(
            $this->boardRowCorrect,
            $this->boardRowIncorrect,
            $this->boardErrorsRowCorrect,
            $this->notesRowCorrect
        );

        $errors = $this->validator->validate($this->activeGame);
        $this->assertCount(1, $errors);
    }

    public function testIncorrectBoardErrorsHasError(): void
    {
        $this->configureActiveGame(
            $this->boardRowCorrect,
            $this->boardRowCorrect,
            $this->boardErrorsRowIncorrect,
            $this->notesRowCorrect
        );

        $errors = $this->validator->validate($this->activeGame);
        $this->assertCount(1, $errors);
    }

    public function testIncorrectNotesHasError(): void
    {
        $this->configureActiveGame(
            $this->boardRowCorrect,
            $this->boardRowCorrect,
            $this->boardErrorsRowCorrect,
            $this->notesRowIncorrect
        );

        $errors = $this->validator->validate($this->activeGame);
        $this->assertCount(1, $errors);
    }

    public function testIncorrectParamsErrors(): void
    {
        $this->configureActiveGame(
            $this->boardRowIncorrect,
            $this->boardRowIncorrect,
            $this->boardErrorsRowIncorrect,
            $this->notesRowIncorrect
        );

        $errors = $this->validator->validate($this->activeGame);
        $this->assertCount(4, $errors);
    }
}
