<?php

namespace App\Validator;

use App\Service\Game\SudokuBoardStructureValidator;
use Symfony\Component\Validator\Constraint;
use Symfony\Component\Validator\ConstraintValidator;
use Symfony\Component\Validator\Exception\UnexpectedTypeException;
use Symfony\Component\Validator\Exception\UnexpectedValueException;

class IsValidSudokuNotesValidator extends ConstraintValidator
{
    public function validate($value, Constraint $constraint): void
    {
        if (!$constraint instanceof IsValidSudokuNotes) {
            throw new UnexpectedTypeException($constraint, IsValidSudokuNotes::class);
        }

        if (!is_array($value)) {
            throw new UnexpectedValueException($value, 'array');
        }

        if (!SudokuBoardStructureValidator::isValidSudokuNotes($value)) {
            $this->context->buildViolation($constraint->message)
                ->setParameter('{{ notes }}', 'notes')
                ->addViolation();
        }
    }
}