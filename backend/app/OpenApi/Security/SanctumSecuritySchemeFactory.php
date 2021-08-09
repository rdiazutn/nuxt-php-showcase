<?php


namespace App\OpenApi\Security;


use GoldSpecDigital\ObjectOrientedOAS\Objects\SecurityScheme;
use Vyuldashev\LaravelOpenApi\Factories\SecuritySchemeFactory;

/**
 * @Annotation
 */
class SanctumSecuritySchemeFactory extends SecuritySchemeFactory
{

    public function build(): SecurityScheme
    {
        return SecurityScheme::create('sanctum')
            ->type(SecurityScheme::TYPE_API_KEY);
    }
}
