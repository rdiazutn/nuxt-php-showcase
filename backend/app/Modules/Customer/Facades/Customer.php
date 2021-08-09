<?php

namespace App\Modules\Customer\Facades;

use Illuminate\Support\Facades\Auth;

class Customer
{

    /**
     * @return \App\Models\Customer
     */
    public static function me(): \App\Models\Customer
    {
        return Auth::user();
    }
}
