<?php

namespace App\Tests\Unit\Validator;

use App\Validator\IsValidSudokuNotes;
use App\Validator\IsValidSudokuNotesValidator;
use Symfony\Component\Validator\ConstraintValidatorInterface;
use Symfony\Component\Validator\Test\ConstraintValidatorTestCase;

class IsValidSudokuNotesValidatorTest extends ConstraintValidatorTestCase
{
    private array $rowCorrect   = [1, 2, 3, 4, 5, 6, null, '',  '9'];
    private array $rowIncorrect = [1, 2, 3, 4, 5, 6, null, '',    0];

    private array $notes = [];

    private function setupNotes(mixed $row): void
    {
        $this->notes = array_fill(0, 9, array_fill(0, 9, $row));
    }

    protected function createValidator(): ConstraintValidatorInterface
    {
        return new IsValidSudokuNotesValidator();
    }

    public function testNotesIsValid(): void
    {
        $this->setupNotes($this->rowCorrect);
        $this->validator->validate($this->notes, new IsValidSudokuNotes());
        $this->assertNoViolation();
    }

    public function testNotesIsInvalid(): void
    {
        $this->setupNotes($this->rowIncorrect);
        $this->validator->validate($this->notes, new IsValidSudokuNotes());

        $this->buildViolation('The "{{ notes }}" has invalid structure.')
            ->setParameter('{{ notes }}', 'notes')
            ->assertRaised();
    }
}