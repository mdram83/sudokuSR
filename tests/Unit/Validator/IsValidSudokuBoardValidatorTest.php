<?php

namespace App\Tests\Unit\Validator;

use App\Validator\IsValidSudokuBoard;
use App\Validator\IsValidSudokuBoardValidator;
use Symfony\Component\Validator\ConstraintValidatorInterface;
use Symfony\Component\Validator\Test\ConstraintValidatorTestCase;

class IsValidSudokuBoardValidatorTest extends ConstraintValidatorTestCase
{
    private array $rowCorrect   = [null, '', '1', 1, '9', 9, 2, 3, 4];
    private array $rowIncorrect = [null, '', '1', 1, '9', 9, 2, 3,  ];

    private array $board = [];

    private function setupBoard(mixed $row): void
    {
        $this->board = array_fill(0, 9, $row);
    }

    protected function createValidator(): ConstraintValidatorInterface
    {
        return new IsValidSudokuBoardValidator();
    }

    public function testBoardIsValid(): void
    {
        $this->setupBoard($this->rowCorrect);
        $this->validator->validate($this->board, new IsValidSudokuBoard());
        $this->assertNoViolation();
    }

    public function testBoardIsInvalid(): void
    {
        $this->setupBoard($this->rowIncorrect);
        $this->validator->validate($this->board, new IsValidSudokuBoard());

        $this->buildViolation('The "{{ board }}" has invalid structure.')
            ->setParameter('{{ board }}', 'board')
            ->assertRaised();
    }
}