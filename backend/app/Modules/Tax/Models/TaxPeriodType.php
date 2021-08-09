<?php


namespace App\Modules\Tax\Models;


use BenSampo\Enum\Enum;

class TaxPeriodType extends Enum
{
    const MONTHLY = 'Monthly';
    const YEARLY = 'Yearly';
}
