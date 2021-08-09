<?php

namespace Database\Factories\Modules\Tax\Models;

use App\Modules\Tax\Models\Tax;
use App\Modules\Tax\Models\TaxPeriodType;
use Illuminate\Database\Eloquent\Factories\Factory;

class TaxFactory extends Factory
{
    /**
     * The name of the factory's corresponding model.
     *
     * @var string
     */
    protected $model = Tax::class;

    /**
     * Define the model's default state.
     *
     * @return array
     */
    public function definition()
    {
        return [
            'name' => 'Impuesto',
            'short_name' => 'IM',
            'period_type' => TaxPeriodType::MONTHLY
        ];
    }

    /**
     * @param string $name
     * @param string $shortName
     * @param string $periodType
     * @return TaxFactory
     */
    public function default(string $name, string $shortName, string $periodType): TaxFactory
    {
        return $this->state([
            'name' => $name,
            'short_name' => $shortName,
            'period_type' => $periodType,
        ]);
    }
}
