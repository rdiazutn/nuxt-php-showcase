<?php

namespace Database\Factories\Modules\Profile\Models;

use App\Modules\Profile\Models\CustomerProfileQuestion;
use App\Modules\Profile\Models\ProfileQuestion;
use App\Modules\Profile\Models\ProfileQuestionType;
use Illuminate\Database\Eloquent\Factories\Factory;

class CustomerProfileQuestionFactory extends Factory
{
    /**
     * The name of the factory's corresponding model.
     *
     * @var string
     */
    protected $model = CustomerProfileQuestion::class;

    /**
     * Define the model's default state.
     *
     * @return array
     */
    public function definition()
    {
        return [];
    }

    /**
     * @param ProfileQuestion $question
     * @return CustomerProfileQuestionFactory
     */
    public function answering(ProfileQuestion $question): CustomerProfileQuestionFactory
    {
        return $this->for($question)
            ->state(fn () => [
                'answer' => $this->getAnswer($question)
            ]);
    }

    /**
     * @param ProfileQuestion $question
     * @return array
     */
    private function getAnswer(ProfileQuestion $question): array
    {
        return [
            ProfileQuestionType::COMBO_BOX => ['value' => 'convenio'],
            ProfileQuestionType::INPUT_MULTIPLE_CHOICE => ['BA' => 90, 'CR' => 10],
            ProfileQuestionType::MULTIPLE_CHOICE => ['selected' => [9, 11]],
        ][$question->type->value] ?? [];
    }
}
