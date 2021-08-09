<?php


namespace App\Modules\Document\Models;


use BenSampo\Enum\Enum;

class DocumentStatus extends Enum
{
    const AVAILABLE = 'Available';
    const PENDING = 'Pending';
    const PREPARED = 'Prepared';
}
