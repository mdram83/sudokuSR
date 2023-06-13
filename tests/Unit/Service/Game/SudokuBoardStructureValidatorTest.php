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

    private array $errorsRow = [
        'correct'    => [true, true, true, true, false, false, false, false,  false],
        'zero'       => [true, true, true, true, false, false, false, false,      0],
        'null'       => [true, true, true, true, false, false, false, false,   null],
        'one'        => [true, true, true, true, false, false, false, false,      1],
        'trueString' => [true, true, true, true, false, false, false, false, 'true'],
        'tooShort'   => [true, true, true, true, false, false, false, false,       ],
        'tooLong'    => [true, true, true, true, false, false, false, false,  false, false],
    ];

    private array $notesRow = [
        'correct'        => [1, 2, 3, 4, 5, 6, null, '',  '9'],
        'zero'           => [1, 2, 3, 4, 5, 6, null, '',    0],
        'negativeInt'    => [1, 2, 3, 4, 5, 6, null, '',   -1],
        'negativeString' => [1, 2, 3, 4, 5, 6, null, '', '-1'],
        'tooHighInt'     => [1, 2, 3, 4, 5, 6, null, '',   10],
        'tooHighString'  => [1, 2, 3, 4, 5, 6, null, '', '10'],
        'tooShort'       => [1, 2, 3, 4, 5, 6, null, '',     ],
        'tooLong'        => [1, 2, 3, 4, 5, 6, null, '',  '9', 9],
    ];

    private mixed $notArray = 'notAnArray';

    private array $board;
    private array $boardErrors;
    private array $notes;
    private array $notesErrors;

    private function setupBoard(mixed $row, int $rowsCount = 9): void
    {
        $this->board = array_fill(0, $rowsCount, $row);
    }

    private function setupBoardErrors(mixed $row, int $rowsCount = 9): void
    {
        $this->boardErrors = array_fill(0, $rowsCount, $row);
    }

    private function setupNotes(mixed $row, int $rowsCount = 9): void
    {
        $this->notes = array_fill(0, 9, array_fill(0, $rowsCount, $row));
    }

    private function setupNotesErrors(mixed $row, int $rowsCount = 9): void
    {
        $this->notesErrors = array_fill(0, 9, array_fill(0, $rowsCount, $row));
    }

    private function checkBoardService(): bool
    {
        return SudokuBoardStructureValidator::isValidSudokuBoard($this->board);
    }

    private function checkBoardErrorsService(): bool
    {
        return SudokuBoardStructureValidator::isValidSudokuBoardErrors($this->boardErrors);
    }

    private function checkNotesService(): bool
    {
        return SudokuBoardStructureValidator::isValidSudokuNotes($this->notes);
    }

    private function checkNotesErrorsService(): bool
    {
        return SudokuBoardStructureValidator::isValidSudokuNotesErrors($this->notesErrors);
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
        $this->setupBoardErrors($this->errorsRow['correct']);
        $this->assertTrue($this->checkBoardErrorsService());
    }

    public function testIncorrectBoardErrorsToLessRows(): void
    {
        $this->setupBoardErrors($this->errorsRow['correct'], 8);
        $this->assertFalse($this->checkBoardErrorsService());
    }

    public function testIncorrectBoardErrorsToManyRows(): void
    {
        $this->setupBoardErrors($this->errorsRow['correct'], 10);
        $this->assertFalse($this->checkBoardErrorsService());
    }

    public function testIncorrectBoardErrorsZero(): void
    {
        $this->setupBoardErrors($this->errorsRow['zero']);
        $this->assertFalse($this->checkBoardErrorsService());
    }

    public function testIncorrectBoardErrorsNull(): void
    {
        $this->setupBoardErrors($this->errorsRow['null']);
        $this->assertFalse($this->checkBoardErrorsService());
    }

    public function testIncorrectBoardErrorsOne(): void
    {
        $this->setupBoardErrors($this->errorsRow['one']);
        $this->assertFalse($this->checkBoardErrorsService());
    }

    public function testIncorrectBoardErrorsTrueString(): void
    {
        $this->setupBoardErrors($this->errorsRow['trueString']);
        $this->assertFalse($this->checkBoardErrorsService());
    }

    public function testIncorrectBoardErrorsTooShort(): void
    {
        $this->setupBoardErrors($this->errorsRow['tooShort']);
        $this->assertFalse($this->checkBoardErrorsService());
    }

    public function testIncorrectBoardErrorsTooLong(): void
    {
        $this->setupBoardErrors($this->errorsRow['tooLong']);
        $this->assertFalse($this->checkBoardErrorsService());
    }

    public function testIncorrectBoardErrorsNotArray(): void
    {
        $this->setupBoardErrors($this->notArray);
        $this->assertFalse($this->checkBoardErrorsService());
    }

    public function testCorrectNotes(): void
    {
        $this->setupNotes($this->notesRow['correct']);
        $this->assertTrue($this->checkNotesService());
    }

    public function testIncorrectNotesToLessRows(): void
    {
        $this->setupNotes($this->notesRow['correct'], 8);
        $this->assertFalse($this->checkNotesService());
    }

    public function testIncorrectNotesToManyRows(): void
    {
        $this->setupNotes($this->notesRow['correct'], 10);
        $this->assertFalse($this->checkNotesService());
    }
    public function testIncorrectNotesZero(): void
    {
        $this->setupNotes($this->notesRow['zero']);
        $this->assertFalse($this->checkNotesService());
    }

    public function testIncorrectNotesNegativeInt(): void
    {
        $this->setupNotes($this->notesRow['negativeInt']);
        $this->assertFalse($this->checkNotesService());
    }

    public function testIncorrectNotesNegativeString(): void
    {
        $this->setupNotes($this->notesRow['negativeString']);
        $this->assertFalse($this->checkNotesService());
    }

    public function testIncorrectNotesTooHighInt(): void
    {
        $this->setupNotes($this->notesRow['tooHighInt']);
        $this->assertFalse($this->checkNotesService());
    }

    public function testIncorrectNotesTooHighString(): void
    {
        $this->setupNotes($this->notesRow['tooHighString']);
        $this->assertFalse($this->checkNotesService());
    }

    public function testIncorrectNotesTooShort(): void
    {
        $this->setupNotes($this->notesRow['tooShort']);
        $this->assertFalse($this->checkNotesService());
    }

    public function testIncorrectNotesTooLong(): void
    {
        $this->setupNotes($this->notesRow['tooLong']);
        $this->assertFalse($this->checkNotesService());
    }

    public function testCorrectNotesErrors(): void
    {
        $this->setupNotesErrors($this->errorsRow['correct']);
        $this->assertTrue($this->checkNotesErrorsService());
    }

    public function testIncorrectNotesErrorsToLessRows(): void
    {
        $this->setupNotesErrors($this->errorsRow['correct'], 8);
        $this->assertFalse($this->checkNotesErrorsService());
    }

    public function testIncorrectNotesErrorsToManyRows(): void
    {
        $this->setupNotesErrors($this->errorsRow['correct'], 10);
        $this->assertFalse($this->checkNotesErrorsService());
    }

    public function testIncorrectNotesErrorsZero(): void
    {
        $this->setupNotesErrors($this->errorsRow['zero']);
        $this->assertFalse($this->checkNotesErrorsService());
    }

    public function testIncorrectNotesErrorsNull(): void
    {
        $this->setupNotesErrors($this->errorsRow['null']);
        $this->assertFalse($this->checkNotesErrorsService());
    }

    public function testIncorrectNotesErrorsOne(): void
    {
        $this->setupNotesErrors($this->errorsRow['one']);
        $this->assertFalse($this->checkNotesErrorsService());
    }

    public function testIncorrectNotesErrorsTrueString(): void
    {
        $this->setupNotesErrors($this->errorsRow['trueString']);
        $this->assertFalse($this->checkNotesErrorsService());
    }

    public function testIncorrectNotesErrorsTooShort(): void
    {
        $this->setupNotesErrors($this->errorsRow['tooShort']);
        $this->assertFalse($this->checkNotesErrorsService());
    }

    public function testIncorrectNotesErrorsTooLong(): void
    {
        $this->setupNotesErrors($this->errorsRow['tooLong']);
        $this->assertFalse($this->checkNotesErrorsService());
    }
}