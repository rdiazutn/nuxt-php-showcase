<?php


namespace App\OpenApi\Objects;


class SecurityRequirement extends \GoldSpecDigital\ObjectOrientedOAS\Objects\SecurityRequirement
{
    public function __construct(string $objectId = null)
    {
        parent::__construct($objectId);
        $this->extensions = new Extensions();
    }

    public static function __set_state($data)
    {
        return \App\OpenApi\Objects\SecurityRequirement::create()
            ->securityScheme($data['securityScheme']);
    }
}
