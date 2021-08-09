<?php

namespace App\OpenApi\SecuritySchemes;

use GoldSpecDigital\ObjectOrientedOAS\Objects\SecurityScheme;
use Vyuldashev\LaravelOpenApi\Factories\SecuritySchemeFactory;

class SanctumSecurityScheme extends SecuritySchemeFactory
{
    public function build(): SecurityScheme
    {
        return SecurityScheme::create('sanctum')
            ->type(SecurityScheme::TYPE_API_KEY)
            ->in('header')
            ->name('Authorization')
            ->description('Sanctum authorization');
    }
}
