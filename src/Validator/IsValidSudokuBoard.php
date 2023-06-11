<?php

namespace App\Validator;

use Symfony\Component\Validator\Constraint;

#[\Attribute]
class IsValidSudokuBoard extends Constraint
{
    public string $message = 'The "{{ board }}" has invalid structure.';
    public string $mode = 'strict';
}