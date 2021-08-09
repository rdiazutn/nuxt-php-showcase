<?php


namespace App\Modules\Tax\Models;


use BenSampo\Enum\Enum;

class TaxStatus extends Enum
{
    const AWAITING_INFO = 'AwaitingInfo';
    const PRESENTED = 'Presented';
    const APPROVED = 'Approved';
    const REJECTED = 'Rejected';
}
