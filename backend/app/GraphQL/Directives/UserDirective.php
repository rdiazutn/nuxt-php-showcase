<?php

namespace App\GraphQL\Directives;

use Closure;
use GraphQL\Language\AST\FieldDefinitionNode;
use GraphQL\Language\AST\InputValueDefinitionNode;
use GraphQL\Language\AST\ObjectTypeDefinitionNode;
use Nuwave\Lighthouse\Schema\AST\DocumentAST;
use Nuwave\Lighthouse\Schema\Directives\BaseDirective;
use Nuwave\Lighthouse\Support\Contracts\ArgBuilderDirective;
use Nuwave\Lighthouse\Support\Contracts\ArgManipulator;

class UserDirective extends BaseDirective implements ArgManipulator, ArgBuilderDirective
{
    public static function definition(): string
    {
        return /** @lang GraphQL */ <<<'GRAPHQL'
"""
Replaces the field with a connect to the authenticated user.
"""
directive @user(
    """
    Customise user id attribute.
    """
    attribute: String
) on ARGUMENT_DEFINITION | INPUT_FIELD_DEFINITION
GRAPHQL;
    }

    public function manipulateArgDefinition(DocumentAST &$documentAST, InputValueDefinitionNode &$argDefinition, FieldDefinitionNode &$parentField, ObjectTypeDefinitionNode &$parentType)
    {
        dd($documentAST);
    }

    public function handleBuilder($builder, $value)
    {
        dd($builder);
    }
}
