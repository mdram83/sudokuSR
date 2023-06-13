<?php

namespace App\Tests\Unit\Validator;

use App\Validator\IsValidSudokuNotesErrors;
use App\Validator\IsValidSudokuNotesErrorsValidator;
use Symfony\Component\Validator\ConstraintValidatorInterface;
use Symfony\Component\Validator\Test\ConstraintValidatorTestCase;

class IsValidSudokuNotesErrorsValidatorTest extends ConstraintValidatorTestCase
{
    private array $rowCorrect   = [false, false, false, false, false, false, false, false, true];
    private array $rowIncorrect = [null, 0, '1', false, false, false, false, false, true];

    private array $notesErrors = [];

    private function setupNotesErrors(mixed $row): void
    {
        $this->notesErrors = array_fill(0, 9, array_fill(0, 9, $row));
    }

    protected function createValidator(): ConstraintValidatorInterface
    {
        return new IsValidSudokuNotesErrorsValidator();
    }

    public function testNotesErrorsIsValid(): void
    {
        $this->setupNotesErrors($this->rowCorrect);
        $this->validator->validate($this->notesErrors, new IsValidSudokuNotesErrors());
        $this->assertNoViolation();
    }

    public function testNotesErrorsIsInvalid(): void
    {
        $this->setupNotesErrors($this->rowIncorrect);
        $this->validator->validate($this->notesErrors, new IsValidSudokuNotesErrors());

        $this->buildViolation('The "{{ notesErrors }}" has invalid structure.')
            ->setParameter('{{ notesErrors }}', 'notes errors')
            ->assertRaised();
    }
}