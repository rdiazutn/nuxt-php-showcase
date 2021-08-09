<?php


namespace App\Modules\Profile\Models;


use BenSampo\Enum\Enum;

class InputType extends Enum
{
    const TEXT = 'text';
    const TIME = 'time';
    const NUMBER = 'number';
    const PASSWORD = 'password';
}
