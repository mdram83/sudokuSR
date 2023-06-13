<?php

namespace App\Tests\Unit\Service\Game;

use App\Service\Game\SudokuBoardStructureValidator;
use PHPUnit\Framework\TestCase;

final class SudokuBoardStructureValidatorTest extends TestCase
{
    private array $boardRow = [
        'correct'        => [null, '', '1', 1, '9', 9, 2, 3,    4],
        'zero'           => [null, '', '1', 1, '9', 9, 2, 3,    0],
        'negativeInt'    => [null, '', '1', 1, '9', 9, 2, 3,   -1],
        'negativeString' => [null, '', '1', 1, '9', 9, 2, 3, '-1'],
        'tooHighInt'     => [null, '', '1', 1, '9', 9, 2, 3,   10],
        'tooHighString'  => [null, '', '1', 1, '9', 9, 2, 3, '10'],
        'tooShort'       => [null, '', '1', 1, '9', 9, 2, 3,     ],
        'tooLong'        => [null, '', '1', 1, '9', 9, 2, 3,    4, 4],
    ];

    private array $boardErrorsRow = [
        'correct'    => [true, true, true, true, false, false, false, false,  false],
        'zero'       => [true, true, true, true, false, false, false, false,      0],
        'null'       => [true, true, true, true, false, false, false, false,   null],
        'one'        => [true, true, true, true, false, false, false, false,      1],
        'trueString' => [true, true, true, true, false, false, false, false, 'true'],
        'tooShort'   => [true, true, true, true, false, false, false, false,       ],
        'tooLong'    => [true, true, true, true, false, false, false, false,  false, false],
    ];

    private mixed $notArray = 'notAnArray';

    private array $board;
    private array $boardErrors;

    private function setupBoard(mixed $row, int $rowsCount = 9): void
    {
        $this->board = array_fill(0, $rowsCount, $row);
    }

    private function setupBoardErrors(mixed $row, int $rowsCount = 9): void
    {
        $this->boardErrors = array_fill(0, $rowsCount, $row);
    }

    private function checkBoardService(): bool
    {
        return (SudokuBoardStructureValidator::isValidSudokuBoard($this->board));
    }

    private function checkBoardErrorsService(): bool
    {
        return (SudokuBoardStructureValidator::isValidSudokuBoardErrors($this->boardErrors));
    }

    public function testCorrectBoard(): void
    {
        $this->setupBoard($this->boardRow['correct']);
        $this->assertTrue($this->checkBoardService());
    }

    public function testIncorrectBoardToLessRows(): void
    {
        $this->setupBoard($this->boardRow['correct'], 8);
        $this->assertFalse($this->checkBoardService());
    }

    public function testIncorrectBoardToManyRows(): void
    {
        $this->setupBoard($this->boardRow['correct'], 10);
        $this->assertFalse($this->checkBoardService());
    }

    public function testIncorrectBoardTooShortRows(): void
    {
        $this->setupBoard($this->boardRow['tooShort']);
        $this->assertFalse($this->checkBoardService());
    }

    public function testIncorrectBoardTooLongRows(): void
    {
        $this->setupBoard($this->boardRow['tooLong']);
        $this->assertFalse($this->checkBoardService());
    }

    public function testIncorrectBoardRowZero(): void
    {
        $this->setupBoard($this->boardRow['zero']);
        $this->assertFalse($this->checkBoardService());
    }

    public function testIncorrectBoardRowNegativeInt(): void
    {
        $this->setupBoard($this->boardRow['negativeInt']);
        $this->assertFalse($this->checkBoardService());
    }

    public function testIncorrectBoardRowNegativeString(): void
    {
        $this->setupBoard($this->boardRow['negativeString']);
        $this->assertFalse($this->checkBoardService());
    }

    public function testIncorrectBoardRowTooHighInt(): void
    {
        $this->setupBoard($this->boardRow['tooHighInt']);
        $this->assertFalse($this->checkBoardService());
    }

    public function testIncorrectBoardRowTooHighString(): void
    {
        $this->setupBoard($this->boardRow['tooHighString']);
        $this->assertFalse($this->checkBoardService());
    }

    public function testIncorrectBoardRowNotArray(): void
    {
        $this->setupBoard($this->notArray);
        $this->assertFalse($this->checkBoardService());
    }

    public function testCorrectBoardErrors(): void
    {
        $this->setupBoardErrors($this->boardErrorsRow['correct']);
        $this->assertTrue($this->checkBoardErrorsService());
    }

    public function testIncorrectBoardErrorsToLessRows(): void
    {
        $this->setupBoardErrors($this->boardErrorsRow['correct'], 8);
        $this->assertFalse($this->checkBoardErrorsService());
    }

    public function testIncorrectBoardErrorsToManyRows(): void
    {
        $this->setupBoardErrors($this->boardErrorsRow['correct'], 10);
        $this->assertFalse($this->checkBoardErrorsService());
    }

    public function testIncorrectBoardErrorsZero(): void
    {
        $this->setupBoardErrors($this->boardErrorsRow['zero'], 9);
        $this->assertFalse($this->checkBoardErrorsService());
    }

    public function testIncorrectBoardErrorsNull(): void
    {
        $this->setupBoardErrors($this->boardErrorsRow['null'], 9);
        $this->assertFalse($this->checkBoardErrorsService());
    }

    public function testIncorrectBoardErrorsOne(): void
    {
        $this->setupBoardErrors($this->boardErrorsRow['one'], 9);
        $this->assertFalse($this->checkBoardErrorsService());
    }

    public function testIncorrectBoardErrorsTrueString(): void
    {
        $this->setupBoardErrors($this->boardErrorsRow['trueString'], 9);
        $this->assertFalse($this->checkBoardErrorsService());
    }

    public function testIncorrectBoardErrorsTooShort(): void
    {
        $this->setupBoardErrors($this->boardErrorsRow['tooShort'], 9);
        $this->assertFalse($this->checkBoardErrorsService());
    }

    public function testIncorrectBoardErrorsTooLong(): void
    {
        $this->setupBoardErrors($this->boardErrorsRow['tooLong'], 9);
        $this->assertFalse($this->checkBoardErrorsService());
    }

    public function testIncorrectBoardErrorsNotArray(): void
    {
        $this->setupBoardErrors($this->notArray, 9);
        $this->assertFalse($this->checkBoardErrorsService());
    }
}