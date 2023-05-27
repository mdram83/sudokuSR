<?php

namespace App\Service\Game;

class SudokuKeysCoder
{
    private static string $separator = '.';

    public static function encodeBoard(array $board): array
    {
        $encodedBoard = [];

        foreach ($board as $rowNumber => $row) {
            foreach ($row as $columnNumber => $value) {
                $encodedBoard[$rowNumber.static::$separator.$columnNumber] = $value;
            }
        }

        return $encodedBoard;
    }

    public static function decodeBoard(array $board): array
    {
        $decodedBoard = [];

        foreach ($board as $key => $value) {
            $coordinates = explode(static::$separator, $key);
            $decodedBoard[$coordinates[0]][$coordinates[1]] = $value;
        }

        return $decodedBoard;
    }

    public static function encodeNotes(array $notes): array
    {
        $encodedNotes = [];

        foreach ($notes as $rowNumber => $row) {
            foreach ($row as $columnNumber => $cell) {
                foreach ($cell as $notesIndex => $value) {
                    $encodedNotes[
                        $rowNumber
                        .static::$separator
                        .$columnNumber
                        .static::$separator
                        .$notesIndex
                    ] = $value;
                }
            }
        }

        return $encodedNotes;
    }

    public static function decodeNotes(array $notes): array
    {
        $decodedNotes = [];

        foreach ($notes as $key => $value) {
            $coordinates = explode(static::$separator, $key);
            $decodedNotes[$coordinates[0]][$coordinates[1]][$coordinates[2]] = $value;
        }

        return $decodedNotes;
    }
}
