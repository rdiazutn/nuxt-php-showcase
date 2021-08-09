<?php

namespace App\GraphQL\Mutations;

use App\Modules\Tax\Models\TaxPeriod;

class AnswerIIBBMonthlyDeclaration
{
    /**
     * @param  null  $_
     * @param  array<string, mixed>  $args
     */
    public function __invoke($_, array $args)
    {
        return TaxPeriod::find($args['periodId'])
            ->getIIBBMonthlyDeclaration()
            ->answer($args['input']);
    }
}
