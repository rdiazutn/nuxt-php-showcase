<?php


namespace App\GraphQL\Mutations;


abstract class Mutation
{
    /**
     * @param $_
     * @param array $args
     * @return mixed
     */
    public function __invoke($_, array $args)
    {
        return app()->call([$this, 'handle'], $args);
    }
}
