<?php


namespace App\Modules\Profile\Models;


use BenSampo\Enum\Enum;

class QuestionRule extends Enum
{
    const BETWEEN = 'between';
    const MIN = 'min';
    const MAX = 'max';
    const REQUIRED = 'required';
}
