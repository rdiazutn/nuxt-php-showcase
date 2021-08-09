<?php


namespace App\OpenApi\Extensions;


use App\OpenApi\Security\SanctumSecuritySchemeFactory;
use Vyuldashev\LaravelOpenApi\Factories\ExtensionFactory;

class SecuritySchema extends ExtensionFactory
{

    public function key(): string
    {
        return 'security';
    }

    public function value()
    {
        dd(debug_backtrace());
        return SanctumSecuritySchemeFactory::class;
    }
}
