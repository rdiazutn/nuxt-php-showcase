<?php

namespace App\GraphQL\Mutations;

use App\Modules\Tax\Models\TaxPeriod;
use App\Modules\Tax\Service\TaxPeriodService;

class RejectPresentationDraft extends Mutation
{
    /**
     * @param TaxPeriodService $service
     * @param int $periodId
     * @param string|null $comment
     * @return TaxPeriod
     */
    public function handle(TaxPeriodService $service, int $periodId, string $comment = null): TaxPeriod
    {
        return $service->rejectDraft(
            TaxPeriod::find($periodId),
            $comment
        );
    }
}
