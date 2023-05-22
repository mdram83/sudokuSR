<?php

namespace App\DataFixtures;

use App\Entity\SudokuDifficulty;
use Doctrine\Bundle\FixturesBundle\Fixture;
use Doctrine\Persistence\ObjectManager;

class AppFixtures extends Fixture
{
    public function load(ObjectManager $manager): void
    {
        $this->loadSudokuDifficulty($manager);
    }

    private function loadSudokuDifficulty(ObjectManager $manager): void
    {
        $setup = [
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

        foreach ($setup as $entry) {
            $this->persistSudokuDifficulty($manager, $entry['name'], $entry['level'], $entry['description']);
        }

        $manager->flush();
    }

    private function persistSudokuDifficulty(
        ObjectManager $manager,
        string $name,
        int $level,
        string $description
    ): void
    {
        $sudokuDifficulty = new SudokuDifficulty();
        $sudokuDifficulty->setName($name);
        $sudokuDifficulty->setLevel($level);
        $sudokuDifficulty->setDescription($description);

        $manager->persist($sudokuDifficulty);
    }
}
