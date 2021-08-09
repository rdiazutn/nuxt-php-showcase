<?php


namespace App\Modules\IIBB\IIBBMonthly;


use App\Modules\Argentina\Models\Regions;
use App\Modules\IIBB\IIBBMonthly\Question\IIBBMonthlyBillingQuestion;
use App\Modules\IIBB\Models\NonBillingIncomeConcept;
use App\Modules\IIBB\Models\NotIncomeBillingConcept;
use App\Modules\Layout\InputLayout;
use App\Modules\Tax\Models\TaxDeclaration;

class IIBBMonthlyDeclaration extends TaxDeclaration
{
    public function getBillingAttribute(): IIBBMonthlyBillingQuestion
    {
        return IIBBMonthlyBillingQuestion::make($this->period);
    }

    public function getNotInvoicedAttribute(): array
    {
        $data = collect($this->getOrPreviousValue('not_invoiced'));
        return [
            'concepts' => InputLayout::fromEnum(NonBillingIncomeConcept::class, $data->get('concepts', [])),
            'extra' => $data->get('extra', []),
        ];
    }

    public function getNotIncomeAttribute(): array
    {
        $data = collect($this->getOrPreviousValue('not_income'));
        return [
            'concepts' => InputLayout::fromEnum(NotIncomeBillingConcept::class, $data->get('concepts', [])),
            'extra' => $data->get('extra', []),
        ];
    }

    public function getDeductionsAttribute(): array
    {
        $data = collect($this->getOrPreviousValue('deductions'));
        $regions = $this->getProfile()->getRegions()
            ->mapWithKeys(fn ($value, $key) => [$key => Regions::fromKey($key)->value]);
        return [
            'with_holdings' => InputLayout::fromArray($regions, $data->get('with_holdings', [])),
            'perceptions' => InputLayout::fromArray($regions, $data->get('perceptions', [])),
            'sircreb' => InputLayout::fromArray($regions, $data->get('sircreb', [])),
        ];
    }
}
