<?php

namespace App\Validator;

use App\Service\Game\SudokuBoardStructureValidator;
use Symfony\Component\Validator\Constraint;
use Symfony\Component\Validator\ConstraintValidator;
use Symfony\Component\Validator\Exception\UnexpectedTypeException;
use Symfony\Component\Validator\Exception\UnexpectedValueException;

class IsValidSudokuNotesErrorsValidator extends ConstraintValidator
{
    public function validate($value, Constraint $constraint): void
    {
        if (!$constraint instanceof IsValidSudokuNotesErrors) {
            throw new UnexpectedTypeException($constraint, IsValidSudokuNotesErrors::class);
        }

        if (!is_array($value)) {
            throw new UnexpectedValueException($value, 'array');
        }

        if (!SudokuBoardStructureValidator::isValidSudokuNotesErrors($value)) {
            $this->context->buildViolation($constraint->message)
                ->setParameter('{{ notesErrors }}', 'notes errors')
                ->addViolation();
        }
    }
}