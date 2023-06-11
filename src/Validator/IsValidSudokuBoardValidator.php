<?php

namespace App\Validator;

use App\Service\Game\SudokuBoardStructureValidator;
use Symfony\Component\Validator\Constraint;
use Symfony\Component\Validator\ConstraintValidator;
use Symfony\Component\Validator\Exception\UnexpectedTypeException;
use Symfony\Component\Validator\Exception\UnexpectedValueException;

class IsValidSudokuBoardValidator extends ConstraintValidator
{
    public function validate($value, Constraint $constraint): void
    {
        if (!$constraint instanceof IsValidSudokuBoard) {
            throw new UnexpectedTypeException($constraint, IsValidSudokuBoard::class);
        }

        if (!is_array($value)) {
            throw new UnexpectedValueException($value, 'array');
        }

        if (!SudokuBoardStructureValidator::isValidSudokuBoard($value)) {
            $this->context->buildViolation($constraint->message)
                ->setParameter('{{ board }}', 'board')
                ->addViolation();
        }
    }
}