<?php

namespace App\Service\Game;

class SudokuBoardStructureValidator
{
    private static int $size = 9;
    private static int $minBoardValue = 1;
    private static int $maxBoardValue = 9;

    public static function isValidSudokuBoard(array $board): bool
    {
        return static::hasRight9x9Structure(
            $board,
            SudokuBoardStructureValidator::class . '::hasRightBoardValue'
        );
    }

    public static function isValidSudokuBoardErrors(array $boardErrors): bool
    {
        return static::hasRight9x9Structure(
            $boardErrors,
            SudokuBoardStructureValidator::class . '::hasRightErrorsValue'
        );
    }

    public static function isValidSudokuNotes(array $notes): bool
    {
        return static::hasRight9x9Structure(
            $notes,
            SudokuBoardStructureValidator::class . '::hasRightNotesValues'
        );
    }

    public static function isValidSudokuNotesErrors(array $notesErrors): bool
    {
        return static::hasRight9x9Structure(
            $notesErrors,
            SudokuBoardStructureValidator::class . '::hasRightNotesErrorsValues'
        );
    }

    private static function hasRight9x9Structure(array $board, callable $callback): bool
    {
        if (!static::hasRightSize($board)) {
            return false;
        }

        foreach ($board as $row) {

            if (!is_array($row)) {
                return false;
            }

            if (!static::hasRightSize($row)) {
                return false;
            }

            foreach ($row as $content) {

                if (!call_user_func($callback, $content)) {
                    return false;
                }
            }
        }

        return true;
    }

    private static function hasRightSize(array $checkedArray): bool
    {
        return count($checkedArray) === static::$size;
    }

    private static function hasRightBoardValue(int|string|null $value): bool
    {
        return (
            $value === null
            || $value === ''
            || ((int) $value >= static::$minBoardValue && (int) $value <= static::$maxBoardValue));
    }

    private static function hasRightErrorsValue(bool|string|null $value): bool
    {
        return is_bool($value);
    }

    private static function hasRightNotesValues(array $notes): bool
    {
        if (!static::hasRightSize($notes)) {
            return false;
        }

        foreach ($notes as $key => $value) {

            if ($value !== null && $value !== '' && (
                (int) $key + 1 !== (int) $value
                || (int) $value < static::$minBoardValue
                || (int) $value > static::$maxBoardValue
                )
            ) {
                return false;
            }
        }

        return true;
    }

    private static function hasRightNotesErrorsValues(array $notesErrors): bool
    {
        if (!static::hasRightSize($notesErrors)) {
            return false;
        }

        foreach ($notesErrors as $value) {
            if (!static::hasRightErrorsValue($value)) {
                return false;
            }
        }

        return true;
    }
}