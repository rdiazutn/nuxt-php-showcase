<?php


namespace App\Modules\Profile\Models;


use BenSampo\Enum\Enum;
use Illuminate\Support\Collection;
use Illuminate\Support\Optional;

class ProfileQuestionType extends Enum
{
    const MULTIPLE_CHOICE = 'MultipleChoice';
    const COMBO_BOX = 'ComboBox';
    const INPUT = 'Input';
    const INPUT_MULTIPLE_CHOICE = 'InputMultipleChoice';

    public function mapData(Collection $data, ?CustomerProfileQuestion $answer): array
    {
        return $this->{"map{$this->value}"}($data, optional($answer));
    }

    /**
     * @param Collection $data
     * @param Optional|CustomerProfileQuestion $answer
     * @return array
     */
    protected function mapInput(Collection $data, $answer): array
    {
        return [
            'inputs' => collect($data->get('inputs'))->map(fn ($data) => [
                'key' => $data['key'],
                'label' => $data->get('label'),
                'type' => $data->get('type'),
                'value' => $answer->getAnswer($data['key'])
            ])
        ];
    }

    /**
     * @param Collection $data
     * @param Optional|CustomerProfileQuestion $answer
     * @return array
     */
    protected function mapComboBox(Collection $data, $answer): array
    {
        return [
            'value' => $answer->getAnswer('value'),
            'options' => $this->mapOptions($data)
        ];
    }

    /**
     * @param Collection $data
     * @param Optional|CustomerProfileQuestion $answer
     * @return array
     */
    protected function mapMultipleChoice(Collection $data, $answer): array
    {
        return [
            'selected' => $answer->getAnswer('selected') ?? [],
            'options' => $this->mapOptions($data)
        ];
    }

    protected function mapOptions(Collection $data): Collection
    {
        return collect($data->get('options'))->map(fn ($input) => [
            'label' => $input['attributes']['label'],
            'value' => $input['attributes']['value']
        ]);
    }

    /**
     * @param Collection $data
     * @param Optional|CustomerProfileQuestion $answer
     * @return array
     */
    protected function mapInputMultipleChoice(Collection $data, $answer): array
    {
        return [
            'input_label' => $data->get('input_label'),
            'input_rules' => $data->get('input_rules', []),
            'values' => collect($data->get('options'))->map(fn ($input) => [
                'key' => ($key = $input['attributes']['value']),
                'value' => $answer->getAnswer($key)
            ])->whereNotNull('value'),
            'options' => $this->mapOptions($data)
        ];
    }
}
