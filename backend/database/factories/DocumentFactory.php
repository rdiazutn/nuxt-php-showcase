<?php

namespace Database\Factories;

use App\Modules\Document\Models\Document;
use App\Modules\File\Models\File;
use App\Modules\Document\Models\DocumentStatus;
use App\Modules\Tax\Models\TaxPeriod;
use Illuminate\Database\Eloquent\Factories\Factory;

class DocumentFactory extends Factory
{
    /**
     * The name of the factory's corresponding model.
     *
     * @var string
     */
    protected $model = Document::class;

    /**
     * Define the model's default state.
     *
     * @return array
     */
    public function definition()
    {
        return [
            'title' => $this->faker->title,
            'status' => DocumentStatus::PENDING,
            'taxPeriod' => TaxPeriod::factory()->create(),
            'file' => File::factory()->create(),
        ];
    }
}
