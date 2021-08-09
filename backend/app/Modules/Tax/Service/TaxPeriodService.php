<?php


namespace App\Modules\Tax\Service;


use App\Modules\Tax\Models\TaxPeriod;
use App\Modules\Tax\Models\TaxPeriodStatus;
use App\Modules\Tax\Permission\TaxPermission;
use Illuminate\Support\Facades\Gate;

class TaxPeriodService
{
    /**
     * @param TaxPeriod $period
     * @param array $data
     * @return TaxPeriod
     */
    public function confirmDraft(TaxPeriod $period, array $data): TaxPeriod
    {
        Gate::authorize(TaxPermission::CONFIRM_TAX_PERIOD_DRAFT, $period);
        $period->presentation->update($data);
        $period->update(['status' => TaxPeriodStatus::AWAITING_PRESENTATION]);
        return $period;
    }

    /**
     * TODO add reject comment
     * @param TaxPeriod $period
     * @param string|null $comment
     * @return TaxPeriod
     */
    public function rejectDraft(TaxPeriod $period, ?string $comment): TaxPeriod
    {
        Gate::authorize(TaxPermission::REJECT_TAX_PERIOD_DRAFT, $period);
        $period->update(['status' => TaxPeriodStatus::CREATED]);
        return $period;
    }

    /**
     * @param TaxPeriod $period
     * @return TaxPeriod
     */
    public function confirmVoucher(TaxPeriod $period): TaxPeriod
    {
        Gate::authorize(TaxPermission::CONFIRM_TAX_PERIOD_VOUCHER, $period);
        $period->update(['status' => TaxPeriodStatus::AWAITING_APPROVAL]);
        return $period;
    }

    /**
     * @param TaxPeriod $period
     * @param array $data
     * @return TaxPeriod
     */
    public function rejectVoucher(TaxPeriod $period, array $data): TaxPeriod
    {
        Gate::authorize(TaxPermission::REJECT_TAX_PERIOD_VOUCHER, $period);
        $period->presentation->update($data);
        $period->update(['status' => TaxPeriodStatus::AWAITING_PAYMENT]);
        return $period;
    }

    /**
     * TODO add reject comment
     * @param TaxPeriod $period
     * @param string|null $comment
     * @return TaxPeriod
     */
    public function rejectPresentation(TaxPeriod $period, ?string $comment): TaxPeriod
    {
        Gate::authorize(TaxPermission::REJECT_TAX_PRESENTATION, $period);
        $period->update(['status' => TaxPeriodStatus::AWAITING_RECTIFICATION]);
        return $period;
    }
}
