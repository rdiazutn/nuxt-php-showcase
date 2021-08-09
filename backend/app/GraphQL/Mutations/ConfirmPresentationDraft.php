<?php

namespace App\GraphQL\Mutations;

use App\Modules\Tax\Models\TaxPeriod;
use App\Modules\Tax\Service\TaxPeriodService;

class ConfirmPresentationDraft extends Mutation
{

    /**
     * @param TaxPeriodService $service
     * @param int $periodId
     * @param array $input
     * @return TaxPeriod
     */
    public function handle(TaxPeriodService $service, int $periodId, array $input): TaxPeriod
    {
        return $service->confirmDraft(
            TaxPeriod::find($periodId),
            $input
        );
    }
}
