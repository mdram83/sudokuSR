<?php

namespace App\DataFixtures;

use App\Entity\SudokuDifficulty;
use Doctrine\Bundle\FixturesBundle\Fixture;
use Doctrine\Persistence\ObjectManager;

class AppFixtures extends Fixture
{

    private ObjectManager $manager;
    private array $sudokuDifficulty = [
        [
            'level' => 10,
            'name' => 'easy',
            'description' => 'Easy to spot necessary values without notes or with notes pointing at single value',
        ],
        [
            'level' => 20,
            'name' => 'medium',
            'description' => 'Requires some techniques as pairs identification or pointing numbers',
        ],
        [
            'level' => 30,
            'name' => 'hard',
            'description' => 'Requires advanced techniques as X-wing or Y-wing',
        ],
    ];

    public function load(ObjectManager $manager): void
    {
        $this->manager = $manager;
        $this->loadSudokuDifficulty();
    }

    private function loadSudokuDifficulty(): void
    {
        foreach ($this->sudokuDifficulty as $entry) {
            $sudokuDifficulty = new SudokuDifficulty();
            $sudokuDifficulty->setName($entry['name']);
            $sudokuDifficulty->setLevel($entry['level']);
            $sudokuDifficulty->setDescription($entry['description']);

            $this->manager->persist($sudokuDifficulty);
        }
        $this->manager->flush();
    }
}
