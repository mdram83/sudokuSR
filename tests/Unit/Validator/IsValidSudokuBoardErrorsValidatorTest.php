<?php

namespace App\Tests\Unit\Validator;

use App\Validator\IsValidSudokuBoardErrors;
use App\Validator\IsValidSudokuBoardErrorsValidator;
use Symfony\Component\Validator\ConstraintValidatorInterface;
use Symfony\Component\Validator\Test\ConstraintValidatorTestCase;

class IsValidSudokuBoardErrorsValidatorTest extends ConstraintValidatorTestCase
{
    private array $rowCorrect   = [false, false, false, false, false, false, false, false, true];
    private array $rowIncorrect = [null, 0, '1', false, false, false, false, false, true];

    private array $boardErrors = [];

    private function setupBoardErrors(mixed $row): void
    {
        $this->boardErrors = array_fill(0, 9, $row);
    }

    protected function createValidator(): ConstraintValidatorInterface
    {
        return new IsValidSudokuBoardErrorsValidator();
    }

    public function testBoardIsValid(): void
    {
        $this->setupBoardErrors($this->rowCorrect);
        $this->validator->validate($this->boardErrors, new IsValidSudokuBoardErrors());
        $this->assertNoViolation();
    }

    public function testBoardIsInvalid(): void
    {
        $this->setupBoardErrors($this->rowIncorrect);
        $this->validator->validate($this->boardErrors, new IsValidSudokuBoardErrors());

        $this->buildViolation('The "{{ boardErrors }}" has invalid structure.')
            ->setParameter('{{ boardErrors }}', 'board errors')
            ->assertRaised();
    }
}