<?php

namespace App\Tests\Integration;

use App\Entity\ActiveGame;
use Symfony\Bundle\FrameworkBundle\Test\KernelTestCase;
use Symfony\Component\Validator\Validator\ValidatorInterface;
use Symfony\Component\DependencyInjection\ContainerInterface;

final class ActiveGameValidationTest extends KernelTestCase
{
    private array $boardCorrect = [
        [4, null, 6, 7, null, null, null, 5, null],
        [null, null, null, null, null, 8, null, 6, null],
        [null, null, 8, null, 5, null, 1, null, 2],
        [9, null, null, 1, null, 5, null, 8, null],
        [null, null, 7, null, 9, null, 5, null, null],
        [null, 5, null, 8, null, 4, null, null, 3],
        [7, null, 4, null, 1, null, 8, null, null],
        [null, 8, null, 9, null, null, null, null, null],
        [null, 6, null, null, null, 7, 2, null, 5],
    ];

    private array $boardIncorrect = [
        [0, null, 6, 7, null, null, null, 5, null],
        [0, null, null, null, null, 8, null, 6, null],
        [0, null, 8, null, 5, null, 1, null, 2],
        [0, null, null, 1, null, 5, null, 8, null],
        [0, null, 7, null, 9, null, 5, null, null],
        [0, 5, null, 8, null, 4, null, null, 3],
        [0, null, 4, null, 1, null, 8, null, null],
        [0, 8, null, 9, null, null, null, null, null],
        [0, 6, null, null, null, 7, 2, null, 5],
    ];

    private ValidatorInterface $validator;
    private ActiveGame $activeGame;

    final public function setUp(): void
    {
        self::bootKernel();
        $container = self::getContainer();
        $this->validator = $container->get(ValidatorInterface::class);
        $this->activeGame = new ActiveGame();

    }

    public function testCorrectBoardNoErrors(): void
    {
        $this->activeGame->setBoard($this->boardCorrect);
        $errors = $this->validator->validate($this->activeGame);
        $this->assertCount(0, $errors);
    }

    public function testIncorrectBoardHasErrors(): void
    {
        $this->activeGame->setBoard($this->boardIncorrect);
        $errors = $this->validator->validate($this->activeGame);
        $this->assertCount(1, $errors);
    }
}
