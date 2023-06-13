<?php

namespace App\Validator;

use Symfony\Component\Validator\Constraint;

#[\Attribute]
class IsValidSudokuNotesErrors extends Constraint
{
    public string $message = 'The "{{ notesErrors }}" has invalid structure.';
    public string $mode = 'strict';
}