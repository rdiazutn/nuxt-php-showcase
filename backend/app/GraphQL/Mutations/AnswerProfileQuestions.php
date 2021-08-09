<?php

namespace App\GraphQL\Mutations;

use App\Modules\Customer\Facades\Customer;
use Illuminate\Support\Collection;

class AnswerProfileQuestions
{
    /**
     * @param null $_
     * @param array<string, mixed> $args
     * @return Collection
     */
    public function __invoke($_, array $args): Collection
    {
        return collect($args['answers'])->map(function (array $answer) {
            $values = collect($answer['values'] ?? [])->mapWithKeys(fn ($value) => [
                $value['key'] => $value['value']
            ]);
            $selected = isset($answer['selected'])? ['selected' => $answer['selected'] ?? null] : [];
            $value = isset($answer['value'])? ['value' => $answer['value'] ?? null] : [];
            $answer['answer'] = $values->merge($selected)->merge($value);
            Customer::me()->profileQuestions()
                ->where('profile_question_id', $answer['profile_question_id'])
                ->delete();
            return Customer::me()->profileQuestions()->create($answer);
        });
    }
}
