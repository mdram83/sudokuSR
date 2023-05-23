<?php

namespace App\Entity;

use App\Repository\SudokuRepository;
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
        $board = [];
        foreach ($this->board as $key => $value) {
            $coordinates = explode('.', $key);
            $board[$coordinates[0]][$coordinates[1]] = $value;
        }
        return $board;
    }

    public function setBoard(array $board): self
    {
        foreach ($board as $rowNumber => $row) {
            foreach ($row as $columnNumber => $value) {
                $this->board["$rowNumber.$columnNumber"] = $value;
            }
        }
        $this->setHash();
        return $this;
    }

    public function getCreatedAt(): ?\DateTimeInterface
    {
        return $this->createdAt;
    }
}
