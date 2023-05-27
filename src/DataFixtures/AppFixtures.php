<?php

namespace App\DataFixtures;

use App\Entity\ActiveGame;
use App\Entity\Sudoku;
use App\Entity\SudokuDifficulty;
use Doctrine\Bundle\FixturesBundle\Fixture;
use Doctrine\Common\Collections\ArrayCollection;
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
    private array $sudoku = [
        ['board' => [
            [4, null, 6, 7, null, null, null, 5, null],
            [null, null, null, null, null, 8, null, 6, null],
            [null, null, 8, null, 5, null, 1, null, 2],
            [9, null, null, 1, null, 5, null, 8, null],
            [null, null, 7, null, 9, null, 5, null, null],
            [null, 5, null, 8, null, 4, null, null, 3],
            [7, null, 4, null, 1, null, 8, null, null],
            [null, 8, null, 9, null, null, null, null, null],
            [null, 6, null, null, null, 7, 2, null, 5],
        ]],
        ['board' => [
            [null, null, null, null, null, null, null, 1, null],
            [null, null, null, null, null, 2, null, null, 3],
            [null, null, null, 4, null, null, null, null, null],
            [null, null, null, null, null, null, 5, null, null],
            [6, null, 1, 7, null, null, null, null, null],
            [null, null, 4, 1, null, null, null, null, null],
            [null, 5, null, null, null, null, 2, null, null],
            [null, null, null, null, 8, null, null, 6, null],
            [null, 3, null, 9, 1, null, null, null, null],
        ]],
        ['board' => [
            [1, 2, 3, 4, 5, 6, 7, 8, 9],
            [7, 8, 9, 1, 2, 3, 4, 5, 6],
            [4, 5, 6, 7, 8, 9, 1, 2, 3],
            [9, 1, 2, 3, 4, 5, 6, 7, 8],
            [6, 7, 8, 9, 1, 2, 3, 4, 5],
            [3, 4, 5, 6, 7, 8, 9, 1, 2],
            [8, 9, 1, 2, 3, 4, 5, 6, 7],
            [5, 6, 7, 8, 9, 1, 2, 3, 4],
            [2, 3, 4, 5, 6, 7, 8, null, null],
        ]],
        ['board' => [
            [null, null, 2, 7, null, 9, 3, 8, null],
            [4, null, null, null, null, null, null, 2, null],
            [null, null, null, null, null, 1, null, null, null],
            [null, null, null, null, 8, null, null, null, null],
            [null, null, 4, 3, null, 2, 9, null, null],
            [null, 5, null, null, null, null, null, null, 6],
            [6, null, null, 8, null, 7, null, null, 9],
            [null, null, null, null, 4, null, 8, null, null],
            [null, null, 7, null, 1, null, null, null, null],
        ]],
        ['board' => [
            [9, null, null, null, 6, null, null, null, 3],
            [null, 2, null, 4, null, 9, null, 8, null],
            [null, null, 5, null, null, null, 4, null, null],
            [null, 1, null, 8, null, 5, null, 7, null],
            [2, null, null, null, null, null, null, null, 1],
            [null, 7, null, 9, null, 4, null, 2, null],
            [null, null, 9, null, null, null, 1, null, null],
            [null, 5, null, 6, null, 7, null, 3, null],
            [6, null, null, null, 9, null, null, null, 7],
        ]],
        ['board' => [
            [null, null, null, 8, 1, 2, 5, null, 4],
            [null, null, 8, null, 6, null, null, null, null],
            [null, null, null, null, null, null, 8, 9, null],
            [5, null, null, 1, 4, null, null, null, 3],
            [7, 6, null, null, null, null, 9, null, 8],
            [4, null, null, null, 8, 7, null, null, 5],
            [8, 2, null, 6, 3, 1, null, null, null],
            [null, null, null, null, 9, null, null, 8, null],
            [null, 9, 6, null, null, null, null, null, null],
        ]],
        ['board' => [
            [null, null, 1, null, null, null, null, null, 5],
            [null, null, null, null, 5, null, 9, null, null],
            [null, 5, 7, null, 2, 9, null, null, 3],
            [null, 2, null, 7, 1, null, null, 9, null],
            [null, null, null, 9, 8, 5, null, null, null],
            [3, 8, null, 4, 6, 2, 1, 5, null],
            [null, null, 2, 8, null, 1, null, 7, 4],
            [null, null, null, null, null, null, null, null, 9],
            [7, 6, null, 2, null, null, null, null, null],
        ]],
        ['board' => [
            [null, null, null, null, null, null, null, null, null],
            [null, null, null, 7, null, null, 3, 9, 6],
            [4, null, null, 8, null, 2, null, 5, null],
            [null, 8, 5, 4, null, null, null, null, null],
            [null, null, null, null, 6, 1, null, 2, null],
            [9, null, null, null, null, null, null, null, null],
            [null, 2, null, null, 1, null, null, null, null],
            [null, null, null, null, null, 7, null, null, null],
            [5, null, null, 9, null, 4, null, 7, null],
        ]],
//        ['board' => [
//            [null, null, null, null, null, null, null, null, null],
//            [null, null, null, null, null, null, null, null, null],
//            [null, null, null, null, null, null, null, null, null],
//            [null, null, null, null, null, null, null, null, null],
//            [null, null, null, null, null, null, null, null, null],
//            [null, null, null, null, null, null, null, null, null],
//            [null, null, null, null, null, null, null, null, null],
//            [null, null, null, null, null, null, null, null, null],
//            [null, null, null, null, null, null, null, null, null],
//        ]],
    ];
    private array $activeGame = [
        'sudoku' => null,
        'anonymousUser' => '1',
        'initialBoard' => [
            [4, null, 6, 7, null, null, null, 5, null],
            [null, null, null, null, null, 8, null, 6, null],
            [null, null, 8, null, 5, null, 1, null, 2],
            [9, null, null, 1, null, 5, null, 8, null],
            [null, null, 7, null, 9, null, 5, null, null],
            [null, 5, null, 8, null, 4, null, null, 3],
            [7, null, 4, null, 1, null, 8, null, null],
            [null, 8, null, 9, null, null, null, null, null],
            [null, 6, null, null, null, 7, 2, null, 5],
        ],
        'board' => [
            [4, 3, 6, 7, 5, null, null, 5, null],
            [null, null, null, null, null, 8, null, 6, null],
            [null, null, 8, null, 5, null, 1, null, 2],
            [9, null, null, 1, null, 5, null, 8, null],
            [null, null, 7, null, 9, null, 5, null, null],
            [null, 5, null, 8, null, 4, null, null, 3],
            [7, null, 4, null, 1, null, 8, null, null],
            [null, 8, null, 9, null, null, null, null, null],
            [null, 6, null, null, null, 7, 2, null, 5],
        ],
        'boardErrors' => [
            [false, false, false, false, true, false, false, false, false],
            [false, false, false, false, false, false, false, false, false],
            [false, false, false, false, false, false, false, false, false],
            [false, false, false, false, false, false, false, false, false],
            [false, false, false, false, false, false, false, false, false],
            [false, false, false, false, false, false, false, false, false],
            [false, false, false, false, false, false, false, false, false],
            [false, false, false, false, false, false, false, false, false],
            [false, false, false, false, false, false, false, false, false],
        ],
        'notes' => [
            [
                [null, null, null, null, null, null, null, null, null],
                [null, null, null, null, null, null, null, null, null],
                [null, null, null, null, null, null, null, null, null],
                [null, null, null, null, null, null, null, null, null],
                [null, null, null, null, null, null, null, null, null],
                [1, 3, null, null, null, null, null, null, null],
                [null, null, null, null, null, null, null, null, null],
                [null, null, null, null, null, null, null, null, null],
                [null, null, null, null, null, null, null, null, null],
            ],
            [
                [null, null, null, null, null, null, null, null, null],
                [null, null, null, null, null, null, null, null, null],
                [null, null, null, null, null, null, null, null, null],
                [null, null, null, null, null, null, null, null, null],
                [null, null, null, null, null, null, null, null, null],
                [null, null, null, null, null, null, null, null, null],
                [null, null, null, null, null, null, null, null, null],
                [null, null, null, null, null, null, null, null, null],
                [null, null, null, null, null, null, null, null, null],
            ],
            [
                [null, null, null, null, null, null, null, null, null],
                [null, null, null, null, null, null, null, null, null],
                [null, null, null, null, null, null, null, null, null],
                [null, null, null, null, null, null, null, null, null],
                [null, null, null, null, null, null, null, null, null],
                [null, null, null, null, null, null, null, null, null],
                [null, null, null, null, null, null, null, null, null],
                [null, null, null, null, null, null, null, null, null],
                [null, null, null, null, null, null, null, null, null],
            ],
            [
                [null, null, null, null, null, null, null, null, null],
                [null, null, null, null, null, null, null, null, null],
                [null, null, null, null, null, null, null, null, null],
                [null, null, null, null, null, null, null, null, null],
                [null, null, null, null, null, null, null, null, null],
                [null, null, null, null, null, null, null, null, null],
                [null, null, null, null, null, null, null, null, null],
                [null, null, null, null, null, null, null, null, null],
                [null, null, null, null, null, null, null, null, null],
            ],
            [
                [null, null, null, null, null, null, null, null, null],
                [null, null, null, null, null, null, null, null, null],
                [null, null, null, null, null, null, null, null, null],
                [null, null, null, null, null, null, null, null, null],
                [null, null, null, null, null, null, null, null, null],
                [null, null, null, null, null, null, null, null, null],
                [null, null, null, null, null, null, null, null, null],
                [null, null, null, null, null, null, null, null, null],
                [null, null, null, null, null, null, null, null, null],
            ],
            [
                [null, null, null, null, null, null, null, null, null],
                [null, null, null, null, null, null, null, null, null],
                [null, null, null, null, null, null, null, null, null],
                [null, null, null, null, null, null, null, null, null],
                [null, null, null, null, null, null, null, null, null],
                [null, null, null, null, null, null, null, null, null],
                [null, null, null, null, null, null, null, null, null],
                [null, null, null, null, null, null, null, null, null],
                [null, null, null, null, null, null, null, null, null],
            ],
            [
                [null, null, null, null, null, null, null, null, null],
                [null, null, null, null, null, null, null, null, null],
                [null, null, null, null, null, null, null, null, null],
                [null, null, null, null, null, null, null, null, null],
                [null, null, null, null, null, null, null, null, null],
                [null, null, null, null, null, null, null, null, null],
                [null, null, null, null, null, null, null, null, null],
                [null, null, null, null, null, null, null, null, null],
                [null, null, null, null, null, null, null, null, null],
            ],
            [
                [null, null, null, null, null, null, null, null, null],
                [null, null, null, null, null, null, null, null, null],
                [null, null, null, null, null, null, null, null, null],
                [null, null, null, null, null, null, null, null, null],
                [null, null, null, null, null, null, null, null, null],
                [null, null, null, null, null, null, null, null, null],
                [null, null, null, null, null, null, null, null, null],
                [null, null, null, null, null, null, null, null, null],
                [null, null, null, null, null, null, null, null, null],
            ],
            [
                [null, null, null, null, null, null, null, null, null],
                [null, null, null, null, null, null, null, null, null],
                [null, null, null, null, null, null, null, null, null],
                [null, null, null, null, null, null, null, null, null],
                [null, null, null, null, null, null, null, null, null],
                [null, null, null, null, null, null, null, null, null],
                [null, null, null, null, null, null, null, null, null],
                [null, null, null, null, null, null, null, null, null],
                [null, null, null, null, null, null, null, null, null],
            ],
        ],
        'notesErrors' => [
            [
                [false, false, false, false, false, false, false, false, false],
                [false, false, false, false, false, false, false, false, false],
                [false, false, false, false, false, false, false, false, false],
                [false, false, false, false, false, false, false, false, false],
                [false, false, false, false, false, false, false, false, false],
                [false, true, false, false, false, false, false, false, false],
                [false, false, false, false, false, false, false, false, false],
                [false, false, false, false, false, false, false, false, false],
                [false, false, false, false, false, false, false, false, false],
            ],
            [
                [false, false, false, false, false, false, false, false, false],
                [false, false, false, false, false, false, false, false, false],
                [false, false, false, false, false, false, false, false, false],
                [false, false, false, false, false, false, false, false, false],
                [false, false, false, false, false, false, false, false, false],
                [false, false, false, false, false, false, false, false, false],
                [false, false, false, false, false, false, false, false, false],
                [false, false, false, false, false, false, false, false, false],
                [false, false, false, false, false, false, false, false, false],
            ],
            [
                [false, false, false, false, false, false, false, false, false],
                [false, false, false, false, false, false, false, false, false],
                [false, false, false, false, false, false, false, false, false],
                [false, false, false, false, false, false, false, false, false],
                [false, false, false, false, false, false, false, false, false],
                [false, false, false, false, false, false, false, false, false],
                [false, false, false, false, false, false, false, false, false],
                [false, false, false, false, false, false, false, false, false],
                [false, false, false, false, false, false, false, false, false],
            ],
            [
                [false, false, false, false, false, false, false, false, false],
                [false, false, false, false, false, false, false, false, false],
                [false, false, false, false, false, false, false, false, false],
                [false, false, false, false, false, false, false, false, false],
                [false, false, false, false, false, false, false, false, false],
                [false, false, false, false, false, false, false, false, false],
                [false, false, false, false, false, false, false, false, false],
                [false, false, false, false, false, false, false, false, false],
                [false, false, false, false, false, false, false, false, false],
            ],
            [
                [false, false, false, false, false, false, false, false, false],
                [false, false, false, false, false, false, false, false, false],
                [false, false, false, false, false, false, false, false, false],
                [false, false, false, false, false, false, false, false, false],
                [false, false, false, false, false, false, false, false, false],
                [false, false, false, false, false, false, false, false, false],
                [false, false, false, false, false, false, false, false, false],
                [false, false, false, false, false, false, false, false, false],
                [false, false, false, false, false, false, false, false, false],
            ],
            [
                [false, false, false, false, false, false, false, false, false],
                [false, false, false, false, false, false, false, false, false],
                [false, false, false, false, false, false, false, false, false],
                [false, false, false, false, false, false, false, false, false],
                [false, false, false, false, false, false, false, false, false],
                [false, false, false, false, false, false, false, false, false],
                [false, false, false, false, false, false, false, false, false],
                [false, false, false, false, false, false, false, false, false],
                [false, false, false, false, false, false, false, false, false],
            ],
            [
                [false, false, false, false, false, false, false, false, false],
                [false, false, false, false, false, false, false, false, false],
                [false, false, false, false, false, false, false, false, false],
                [false, false, false, false, false, false, false, false, false],
                [false, false, false, false, false, false, false, false, false],
                [false, false, false, false, false, false, false, false, false],
                [false, false, false, false, false, false, false, false, false],
                [false, false, false, false, false, false, false, false, false],
                [false, false, false, false, false, false, false, false, false],
            ],
            [
                [false, false, false, false, false, false, false, false, false],
                [false, false, false, false, false, false, false, false, false],
                [false, false, false, false, false, false, false, false, false],
                [false, false, false, false, false, false, false, false, false],
                [false, false, false, false, false, false, false, false, false],
                [false, false, false, false, false, false, false, false, false],
                [false, false, false, false, false, false, false, false, false],
                [false, false, false, false, false, false, false, false, false],
                [false, false, false, false, false, false, false, false, false],
            ],
            [
                [false, false, false, false, false, false, false, false, false],
                [false, false, false, false, false, false, false, false, false],
                [false, false, false, false, false, false, false, false, false],
                [false, false, false, false, false, false, false, false, false],
                [false, false, false, false, false, false, false, false, false],
                [false, false, false, false, false, false, false, false, false],
                [false, false, false, false, false, false, false, false, false],
                [false, false, false, false, false, false, false, false, false],
                [false, false, false, false, false, false, false, false, false],
            ],
        ],
        'emptyCellsCount' => 48,
        'difficultyLevel' => [
            'highlightValue' => true,
            'highlightNotes' => true,
            'highlightGrid' => true,
            'highlightErrors' => true,
            'highlightRemaining' => true,
            'quickNotesAvailability' => false,
            'quickNotesRemoval' => true,
            'undoAvailability' => true,
        ],
        'timer' => 100,
    ];

    public function __construct(
        private $difficulties = new ArrayCollection(),
        private $sudokus = new ArrayCollection(),
    )
    {

    }

    public function load(ObjectManager $manager): void
    {
        $this->manager = $manager;
        $this->loadSudokuDifficulty();
        $this->loadSudoku();
        $this->loadActiveGame();
    }

    private function loadSudokuDifficulty(): void
    {
        foreach ($this->sudokuDifficulty as $entry) {
            $sudokuDifficulty = new SudokuDifficulty();
            $sudokuDifficulty->setName($entry['name']);
            $sudokuDifficulty->setLevel($entry['level']);
            $sudokuDifficulty->setDescription($entry['description']);

            $this->manager->persist($sudokuDifficulty);

            $this->difficulties->add($sudokuDifficulty);
        }
        $this->manager->flush();
    }

    private function loadSudoku(): void
    {
        foreach ($this->sudoku as $entry) {
            $sudoku = new Sudoku();
            $sudoku->setBoard($entry['board']);

            $difficulty = $this->difficulties->get(array_rand($this->difficulties->toArray()));
            $sudoku->setDifficulty($difficulty);

            $this->manager->persist($sudoku);

            $this->sudokus->add($sudoku);
        }
        $this->manager->flush();
    }

    private function loadActiveGame(): void
    {
        $activeGame = new ActiveGame();
        $activeGame->setAnonymousUser($this->activeGame['anonymousUser']);
        $activeGame->setInitialBoard($this->activeGame['initialBoard']);
        $activeGame->setBoard($this->activeGame['board']);
        $activeGame->setBoardErrors($this->activeGame['boardErrors']);
        $activeGame->setNotes($this->activeGame['notes']);
        $activeGame->setNotesErrors($this->activeGame['notesErrors']);
        $activeGame->setEmptyCellsCount($this->activeGame['emptyCellsCount']);
        $activeGame->setDifficultyLevel($this->activeGame['difficultyLevel']);
        $activeGame->setTimer($this->activeGame['timer']);

        $sudoku =  $this->sudokus->get(array_rand($this->sudokus->toArray()));
        $activeGame->setSudoku($sudoku);

        $this->manager->persist($activeGame);
        $this->manager->flush();
    }
}
