<?php

namespace App\Validator;

use Symfony\Component\Validator\Constraint;

#[\Attribute]
class IsValidSudokuBoardErrors extends Constraint
{
    public string $message = 'The "{{ boardErrors }}" has invalid structure.';
    public string $mode = 'strict';
}