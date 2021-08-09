<?php

namespace App\Nova\Fields;

use App\Modules\Profile\Models\InputType;
use App\Modules\Profile\Models\ProfileQuestionType;
use App\Modules\Profile\Models\QuestionRule;
use Epartment\NovaDependencyContainer\NovaDependencyContainer;
use Illuminate\Http\Resources\MergeValue;
use Laravel\Nova\Fields\Boolean;
use Laravel\Nova\Fields\Select;
use Laravel\Nova\Fields\Text;
use Laravel\Nova\Makeable;
use R64\NovaFields\Row;
use Whitecube\NovaFlexibleContent\Flexible;

class QuestionField extends MergeValue
{
    use Makeable;

    public function __construct()
    {
        parent::__construct(collect($this->options())
            ->map(fn ($components, $option) =>
            NovaDependencyContainer::make($components)
                ->dependsOn('type', $option)
            )->merge($this->rules('Rules', 'data->rules'))
        );
    }

    protected function rules(string $name, string $attribute): array
    {
        return [
            Flexible::make($name, $attribute)
                ->addLayout('Rule', 'rules', [
                    Select::make('Key')
                        ->options(QuestionRule::asSelectArray()),
                    Text::make('Parameters')
                ])
        ];
    }

    /**
     * @return array
     */
    protected function options(): array
    {
        return [
            ProfileQuestionType::MULTIPLE_CHOICE => $this->multipleChoice(),
            ProfileQuestionType::INPUT_MULTIPLE_CHOICE => $this->inputMultipleChoice(),
            ProfileQuestionType::COMBO_BOX => $this->comboBox(),
            ProfileQuestionType::INPUT => $this->input()
        ];
    }

    protected function multipleChoice(): array
    {
        return [
            Flexible::make('Options', 'data->options')
                ->addLayout('Option', 'options', [
                    Text::make('Label')->rules('required'),
                    Text::make('Value')->rules('required', 'unique')
                ])
        ];
    }

    protected function inputMultipleChoice(): array
    {
        return array_merge([
                Text::make('Input Label', 'data->input_label')
            ],
            $this->multipleChoice(),
            $this->rules('Input Rules', 'data->input_rules')
        );
    }

    protected function comboBox(): array
    {
        return $this->multipleChoice();
    }

    protected function input(): array
    {
        return [
            Text::make('Rules', 'data->rules')
        ];
    }
}
