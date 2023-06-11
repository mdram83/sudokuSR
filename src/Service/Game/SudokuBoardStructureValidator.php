<?php

namespace App\Service\Game;

class SudokuBoardStructureValidator
{
    private static int $size = 9;
    private static int $minBoardValue = 1;
    private static int $maxBoardValue = 9;

    public static function isValidSudokuBoard(array $board): bool
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

            foreach ($row as $value) {

                if (!static::hasRightBoardValue($value)) {
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
}