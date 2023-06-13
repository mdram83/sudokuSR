<?php

namespace App\Validator;

use Symfony\Component\Validator\Constraint;

#[\Attribute]
class IsValidSudokuNotes extends Constraint
{
    public string $message = 'The "{{ notes }}" has invalid structure.';
    public string $mode = 'strict';
}