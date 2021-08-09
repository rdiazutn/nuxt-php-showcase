<?php

namespace Database\Factories\Modules\Profile\Models;

use App\Modules\Profile\Models\ProfileQuestion;
use App\Modules\Profile\Models\ProfileQuestionType;
use Illuminate\Database\Eloquent\Factories\Factory;
use Illuminate\Support\Str;

class ProfileQuestionFactory extends Factory
{
    /**
     * The name of the factory's corresponding model.
     *
     * @var string
     */
    protected $model = ProfileQuestion::class;

    /**
     * Define the model's default state.
     *
     * @return array
     */
    public function definition()
    {
        return [
            'title' => $this->faker->text(15),
            'body' => $this->faker->text(),
            'type' => $type = $this->faker->randomElement(ProfileQuestionType::getValues()),
            'image' => $this->faker->imageUrl(),
            'order' => $this->faker->randomDigit,
            'data' => [],
        ];
    }

    public function default(string $title, string $body, int $order, string $image): ProfileQuestionFactory
    {
        return $this->state([
            'title' => $title,
            'body' => $body,
            'order' => $order,
            'image' => $image
        ]);
    }

    public function input(string $label, string $type): ProfileQuestionFactory
    {
        return $this->state([
            'type' => ProfileQuestionType::INPUT,
            'data' => [
                'label' => $label,
                'type' => $type
            ]
        ]);
    }

    public function comboBox(array $options): ProfileQuestionFactory
    {
        return $this->state([
            'type' => ProfileQuestionType::COMBO_BOX,
            'data' => [
                'options' => collect($options)->map(fn ($label, $key) => [
                    'key' => Str::random(),
                    'layout' => 'options',
                    'attributes' => [
                        'label' => $label,
                        'value' => $key,
                    ],
                ])
            ]
        ]);
    }

    public function multipleChoice(array $options): ProfileQuestionFactory
    {
        return $this->comboBox($options)->state([
            'type' => ProfileQuestionType::MULTIPLE_CHOICE
        ]);
    }

    public function inputMultipleChoice(array $options, string $inputLabel = null): ProfileQuestionFactory
    {
        return $this->multipleChoice($options)->state(fn ($options) => [
            'type' => ProfileQuestionType::INPUT_MULTIPLE_CHOICE,
            'data' => array_merge($options['data'], [
                'input_label' => $inputLabel ?? $this->faker->title
            ])
        ]);
    }
}
