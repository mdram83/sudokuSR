<?php

namespace App\Entity;

use App\Repository\SudokuRepository;
use App\Service\Game\SudokuKeysCoder;
use Doctrine\DBAL\Types\Types;
use Doctrine\ORM\Mapping as ORM;

#[ORM\Entity(repositoryClass: SudokuRepository::class)]
class Sudoku
{
    #[ORM\Id]
    #[ORM\GeneratedValue]
    #[ORM\Column]
    private ?int $id = null;

    #[ORM\Column(length: 32, unique: true)]
    private ?string $hash = null;

    #[ORM\Column]
    private array $board = [];

    #[ORM\Column(type: Types::DATETIME_MUTABLE, options: ['default' => 'CURRENT_TIMESTAMP'])]
    private ?\DateTimeInterface $createdAt = null;

    #[ORM\ManyToOne]
    #[ORM\JoinColumn(nullable: false)]
    private ?SudokuDifficulty $difficulty = null;

    public function __construct()
    {
        $this->createdAt = new \DateTime();
    }

    public function getId(): ?int
    {
        return $this->id;
    }

    public function getHash(): ?string
    {
        return $this->hash;
    }

    public function setHash(): self
    {
        $this->hash = md5(json_encode($this->board));
        return $this;
    }

    public function getBoard(): array
    {
        return SudokuKeysCoder::decodeBoard($this->board);
    }

    public function setBoard(array $board): self
    {
        $this->board = SudokuKeysCoder::encodeBoard($board);
        $this->setHash();
        return $this;
    }

    public function getCreatedAt(): ?\DateTimeInterface
    {
        return $this->createdAt;
    }

    public function getDifficulty(): ?SudokuDifficulty
    {
        return $this->difficulty;
    }

    public function setDifficulty(?SudokuDifficulty $difficulty): self
    {
        $this->difficulty = $difficulty;

        return $this;
    }
}
