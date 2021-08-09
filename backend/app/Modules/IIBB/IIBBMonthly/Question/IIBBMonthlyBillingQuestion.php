<?php


namespace App\Modules\IIBB\IIBBMonthly\Question;


use App\Modules\AFIP\Models\Activities;
use App\Modules\Argentina\Models\Regions;
use App\Modules\IIBB\Models\CustomerCondition;
use App\Modules\Tax\Models\TaxDeclaration;
use Illuminate\Support\Collection;

class IIBBMonthlyBillingQuestion extends TaxDeclaration
{
    /**
     * TODO 20210602 Get from customer profile
     * @return CustomerCondition
     */
    public function getConditionAttribute(): CustomerCondition
    {
        return CustomerCondition::RESPONSABLE_INSCRIPTO();
    }

    /**
     * @return Collection
     */
    public function getActivitiesAttribute(): Collection
    {
        return $this->getProfile()->getActivities()
            ->map(fn ($activity) => [
                'key' => $activity,
                'label' => Activities::all()[$activity],
                'regions' => $this->getRegions($activity),
            ]);
    }

    /**
     * @param string $activity
     * @return Collection
     */
    private function getRegions(string $activity): Collection
    {
        return $this->getProfile()->getRegions()
            ->map(fn ($coefficient, $region) => [
                'key' => $region,
                'name' => Regions::fromKey($region)->value,
                'percentage' => $coefficient,
                'value' => $this->getValue("billing.activities.$activity.regions.$region.value"),
                'iva' => $this->getValue("billing.activities.$activity.regions.$region.iva"),
            ]);
    }
}
