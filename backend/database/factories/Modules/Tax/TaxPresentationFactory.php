<?php

namespace Database\Factories\Modules\Tax;

use App\Models\User;
use App\Modules\Tax\Models\TaxPeriodStatus;
use App\Modules\Tax\Presentation\Models\TaxPresentation;
use Database\Factories\FileFactory;
use Database\Factories\Modules\Tax\Models\TaxPeriodFactory;
use Illuminate\Database\Eloquent\Factories\Factory;
use Illuminate\Support\Facades\Hash;
use Illuminate\Support\Str;

class TaxPresentationFactory extends Factory
{
    /**
     * The name of the factory's corresponding model.
     *
     * @var string
     */
    protected $model = TaxPresentation::class;

    /**
     * Define the model's default state.
     *
     * @return array
     */
    public function definition()
    {
        return [
            'amount' => $this->faker->randomFloat(),
            'balance' => $this->faker->randomFloat(2, 0, 10000),
            'draft_id' => FileFactory::new()->create()->getKey(),
        ];
    }

    /**
     * @return TaxPresentationFactory
     */
    public function default(): TaxPresentationFactory
    {
        return $this
            ->for(
                TaxPeriodFactory::new([
                    'status' => TaxPeriodStatus::DRAFT_VALIDATION
                ])->default()
            );
    }

    /**
     * @return TaxPresentationFactory
     */
    public function withVoucher(): TaxPresentationFactory
    {
        return $this
            ->for(TaxPeriodFactory::new(['status' => TaxPeriodStatus::AWAITING_PAYMENT])->default())
            ->for(FileFactory::new(), 'voucher')
            ->for(FileFactory::new(), 'presentation');
    }
}
