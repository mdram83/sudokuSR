<?php

namespace App\Validator;

use App\Service\Game\SudokuBoardStructureValidator;
use Symfony\Component\Validator\Constraint;
use Symfony\Component\Validator\ConstraintValidator;
use Symfony\Component\Validator\Exception\UnexpectedTypeException;
use Symfony\Component\Validator\Exception\UnexpectedValueException;

class IsValidSudokuBoardErrorsValidator extends ConstraintValidator
{
    public function validate($value, Constraint $constraint): void
    {
        if (!$constraint instanceof IsValidSudokuBoardErrors) {
            throw new UnexpectedTypeException($constraint, IsValidSudokuBoardErrors::class);
        }

        if (!is_array($value)) {
            throw new UnexpectedValueException($value, 'array');
        }

        if (!SudokuBoardStructureValidator::isValidSudokuBoardErrors($value)) {
            $this->context->buildViolation($constraint->message)
                ->setParameter('{{ boardErrors }}', 'board errors')
                ->addViolation();
        }
    }
}