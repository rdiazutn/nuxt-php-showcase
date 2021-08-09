<?php

namespace Database\Factories\Modules\Tax\Models;

use App\Models\Model;
use App\Modules\Tax\Models\TaxPeriod;
use App\Modules\Tax\Models\TaxPeriodStatus;
use Database\Factories\CustomerFactory;
use Illuminate\Database\Eloquent\Factories\Factory;

class TaxPeriodFactory extends Factory
{
    /**
     * The name of the factory's corresponding model.
     *
     * @var string
     */
    protected $model = TaxPeriod::class;

    /**
     * Define the model's default state.
     *
     * @return array
     */
    public function definition()
    {
        return [
            'status' => TaxPeriodStatus::CREATED,
            'period_date' => now(),
        ];
    }

    public function default(): TaxPeriodFactory
    {
        return $this
            ->for(TaxFactory::new())
            ->for(CustomerFactory::new());
    }
}
