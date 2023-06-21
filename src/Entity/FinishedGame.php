<?php

namespace App\Entity;

use App\Repository\FinishedGameRepository;
use Doctrine\ORM\Mapping as ORM;

#[ORM\Entity(repositoryClass: FinishedGameRepository::class)]
#[ORM\UniqueConstraint(
    name: 'finished_game_unique_idx',
    columns: ['sudoku_id', 'anonymous_user']
)]
class FinishedGame
{
    #[ORM\Id]
    #[ORM\GeneratedValue]
    #[ORM\Column]
    private ?int $id = null;

    #[ORM\ManyToOne]
    #[ORM\JoinColumn(nullable: false)]
    private ?Sudoku $sudoku = null;

    #[ORM\Column(length: 255)]
    private ?string $anonymousUser = null;

    #[ORM\Column]
    private ?int $timer = null;

    #[ORM\Column]
    private ?\DateTimeImmutable $finishedAt = null;

    #[ORM\ManyToOne]
    private ?User $activeUser = null;

    public function getId(): ?int
    {
        return $this->id;
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

    public function getAnonymousUser(): ?string
    {
        return $this->anonymousUser;
    }

    public function setAnonymousUser(string $anonymousUser): self
    {
        $this->anonymousUser = $anonymousUser;

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

    public function getFinishedAt(): ?\DateTimeImmutable
    {
        return $this->finishedAt;
    }

    public function setFinishedAt(\DateTimeImmutable $finishedAt): self
    {
        $this->finishedAt = $finishedAt;

        return $this;
    }

    public function getActiveUser(): ?User
    {
        return $this->activeUser;
    }

    public function setActiveUser(?User $activeUser): self
    {
        $this->activeUser = $activeUser;

        return $this;
    }
}
