<?php

namespace App\OpenApi\Responses;

use GoldSpecDigital\ObjectOrientedOAS\Objects\MediaType;
use GoldSpecDigital\ObjectOrientedOAS\Objects\Response;
use GoldSpecDigital\ObjectOrientedOAS\Objects\Schema;
use Vyuldashev\LaravelOpenApi\Factories\ResponseFactory;

class Unauthorized extends ResponseFactory
{
    public function build(): Response
    {
        return Response::unauthorized()
            ->content(
                MediaType::json()
                    ->schema(
                        Schema::object('unauthenticatedResponse')
                            ->properties(
                                Schema::string('message')->example('Unauthenticated.')
                            )
                    )
            );
    }
}
