<?php


namespace App\Modules\Tax;


use App\Models\Customer;
use App\Modules\Tax\Models\TaxPeriod;
use App\Modules\Tax\Models\TaxPeriodStatus;
use App\Modules\Tax\Permission\TaxPermission;
use Illuminate\Support\Facades\Gate;
use Illuminate\Support\ServiceProvider;

class TaxServiceProvider extends ServiceProvider
{
    public function register()
    {
        Gate::define(TaxPermission::CONFIRM_TAX_PERIOD_DRAFT, function (Customer $customer, TaxPeriod $period) {
            return $customer->owns($period) &&
                $period->status->is(TaxPeriodStatus::DRAFT_VALIDATION);
        });
        Gate::define(TaxPermission::REJECT_TAX_PERIOD_DRAFT, function (Customer $customer, TaxPeriod $period) {
            return $customer->owns($period) &&
                $period->status->is(TaxPeriodStatus::DRAFT_VALIDATION);
        });
        Gate::define(TaxPermission::CONFIRM_TAX_PERIOD_VOUCHER, function (Customer $customer, TaxPeriod $period) {
            return $customer->owns($period) &&
                $period->status->is(TaxPeriodStatus::AWAITING_PAYMENT);
        });
        Gate::define(TaxPermission::REJECT_TAX_PERIOD_VOUCHER, function (Customer $customer, TaxPeriod $period) {
            return $customer->owns($period) &&
                $period->status->is(TaxPeriodStatus::AWAITING_PAYMENT);
        });
        Gate::define(TaxPermission::REJECT_TAX_PRESENTATION, function (Customer $customer, TaxPeriod $period) {
            return $customer->owns($period) &&
                $period->status->in(TaxPeriodStatus::withPresentation());
        });
    }
}
