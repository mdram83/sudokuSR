<?php

namespace App\Entity;

use App\Repository\ActiveGameRepository;
use App\Service\Game\SudokuKeysCoder;
use App\Validator\IsValidSudokuNotes;
use Doctrine\DBAL\Types\Types;
use Doctrine\ORM\Mapping as ORM;
use App\Validator\IsValidSudokuBoard;
use App\Validator\IsValidSudokuBoardErrors;

#[ORM\Entity(repositoryClass: ActiveGameRepository::class)]
class ActiveGame
{
    #[ORM\Id]
    #[ORM\GeneratedValue]
    #[ORM\Column]
    private ?int $id = null;

    #[ORM\Column(length: 255, unique: true)]
    private ?string $anonymousUser = null;

    #[ORM\Column]
    private array $initialBoard = [];

    #[ORM\Column]
    private array $board = [];

    #[ORM\Column]
    private array $boardErrors = [];

    #[ORM\Column]
    private array $notes = [];

    #[ORM\Column]
    private array $notesErrors = [];

    #[ORM\Column(type: Types::SMALLINT)]
    private ?int $emptyCellsCount = null;

    #[ORM\Column]
    private array $difficultyLevel = [];

    #[ORM\Column]
    private ?int $timer = null;

    #[ORM\ManyToOne]
    #[ORM\JoinColumn(nullable: false)]
    private ?Sudoku $sudoku = null;

    public function getId(): ?int
    {
        return $this->id;
    }

    public function getAnonymousUser(): ?string
    {
        return $this->anonymousUser;
    }

    public function setAnonymousUser(?string $anonymousUser): self
    {
        $this->anonymousUser = $anonymousUser;

        return $this;
    }

    #[IsValidSudokuBoard]
    public function getInitialBoard(): array
    {
        return SudokuKeysCoder::decodeBoard($this->initialBoard);
    }

    public function setInitialBoard(array $initialBoard): self
    {
        $this->initialBoard = SudokuKeysCoder::encodeBoard($initialBoard);

        return $this;
    }

    #[IsValidSudokuBoard]
    public function getBoard(): array
    {
        return SudokuKeysCoder::decodeBoard($this->board);
    }

    public function setBoard(array $board): self
    {
        $this->board = SudokuKeysCoder::encodeBoard($board);

        return $this;
    }

    #[IsValidSudokuBoardErrors]
    public function getBoardErrors(): array
    {
        return SudokuKeysCoder::decodeBoard($this->boardErrors);
    }

    public function setBoardErrors(array $boardErrors): self
    {
        $this->boardErrors = SudokuKeysCoder::encodeBoard($boardErrors);

        return $this;
    }

    #[IsValidSudokuNotes]
    public function getNotes(): array
    {
        return SudokuKeysCoder::decodeNotes($this->notes);
    }

    public function setNotes(array $notes): self
    {
        $this->notes = SudokuKeysCoder::encodeNotes($notes);

        return $this;
    }

    public function getNotesErrors(): array
    {
        return SudokuKeysCoder::decodeNotes($this->notesErrors);
    }

    public function setNotesErrors(array $notesErrors): self
    {
        $this->notesErrors = SudokuKeysCoder::encodeNotes($notesErrors);

        return $this;
    }

    public function getEmptyCellsCount(): ?int
    {
        return $this->emptyCellsCount;
    }

    public function setEmptyCellsCount(int $emptyCellsCount): self
    {
        $this->emptyCellsCount = $emptyCellsCount;

        return $this;
    }

    public function getDifficultyLevel(): array
    {
        return $this->difficultyLevel;
    }

    public function setDifficultyLevel(array $difficultyLevel): self
    {
        $this->difficultyLevel = $difficultyLevel;

        return $this;
    }

    public function getTimer(): ?int
    {
        return $this->timer;
    }

    public function setTimer(int $timer): self
    {
        $this->timer = $timer;

        return $this;
    }

    public function getSudoku(): ?Sudoku
    {
        return $this->sudoku;
    }

    public function setSudoku(?Sudoku $sudoku): self
    {
        $this->sudoku = $sudoku;

        return $this;
    }
}
