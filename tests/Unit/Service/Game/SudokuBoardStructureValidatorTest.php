<?php

namespace App\Tests\Unit\Service\Game;

use App\Service\Game\SudokuBoardStructureValidator;
use PHPUnit\Framework\TestCase;

final class SudokuBoardStructureValidatorTest extends TestCase
{
    private array $rowCorrect        = [null, '', '1', 1, '9', 9, 2, 3,    4];
    private array $rowZero           = [null, '', '1', 1, '9', 9, 2, 3,    0];
    private array $rowNegativeInt    = [null, '', '1', 1, '9', 9, 2, 3,   -1];
    private array $rowNegativeString = [null, '', '1', 1, '9', 9, 2, 3, '-1'];
    private array $rowTooHighInt     = [null, '', '1', 1, '9', 9, 2, 3,   10];
    private array $rowTooHighString  = [null, '', '1', 1, '9', 9, 2, 3, '10'];
    private array $rowTooShort       = [null, '', '1', 1, '9', 9, 2, 3,     ];
    private array $rowTooLong        = [null, '', '1', 1, '9', 9, 2, 3,    4, 4];
    private mixed $rowNotArray       = 'notAnArray';

    private array $board;

    private function setupBoard(mixed $row, int $rowsCount = 9): void
    {
        $this->board = array_fill(0, $rowsCount, $row);
    }

    private function checkBoardService(): bool
    {
        return (SudokuBoardStructureValidator::isValidSudokuBoard($this->board));
    }

    public function testCorrectBoard(): void
    {
        $this->setupBoard($this->rowCorrect);
        $this->assertTrue($this->checkBoardService());
    }

    public function testToLessRows(): void
    {
        $this->setupBoard($this->rowCorrect, 8);
        $this->assertFalse($this->checkBoardService());
    }

    public function testToMayRows(): void
    {
        $this->setupBoard($this->rowCorrect, 10);
        $this->assertFalse($this->checkBoardService());
    }

    public function testTooShortRows(): void
    {
        $this->setupBoard($this->rowTooShort);
        $this->assertFalse($this->checkBoardService());
    }

    public function testTooLongRows(): void
    {
        $this->setupBoard($this->rowTooLong);
        $this->assertFalse($this->checkBoardService());
    }

    public function testIncorrectBoardRowZero(): void
    {
        $this->setupBoard($this->rowZero);
        $this->assertFalse($this->checkBoardService());
    }

    public function testIncorrectBoardRowNegativeInt(): void
    {
        $this->setupBoard($this->rowNegativeInt);
        $this->assertFalse($this->checkBoardService());
    }

    public function testIncorrectBoardRowNegativeString(): void
    {
        $this->setupBoard($this->rowNegativeString);
        $this->assertFalse($this->checkBoardService());
    }

    public function testIncorrectBoardRowTooHighInt(): void
    {
        $this->setupBoard($this->rowTooHighInt);
        $this->assertFalse($this->checkBoardService());
    }

    public function testIncorrectBoardRowTooHighString(): void
    {
        $this->setupBoard($this->rowTooHighString);
        $this->assertFalse($this->checkBoardService());
    }

    public function testIncorrectBoardRowNotArray(): void
    {
        $this->setupBoard($this->rowNotArray);
        $this->assertFalse($this->checkBoardService());
    }
}