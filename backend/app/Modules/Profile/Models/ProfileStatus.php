<?php


namespace App\Modules\Profile\Models;


use BenSampo\Enum\Enum;

class ProfileStatus extends Enum
{
    const PENDING = 'pending';
    const COMPLETED = 'completed';
}
