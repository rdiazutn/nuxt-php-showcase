<?php

namespace App\GraphQL\Mutations;

use App\Modules\Tax\Models\TaxPeriod;
use App\Modules\Tax\Service\TaxPeriodService;

class ConfirmPresentationVoucher extends Mutation
{
    /**
     * @param TaxPeriodService $service
     * @param int $periodId
     * @return TaxPeriod
     */
    public function handle(TaxPeriodService $service, int $periodId): TaxPeriod
    {
        return $service->confirmVoucher(
            TaxPeriod::find($periodId)
        );
    }
}
