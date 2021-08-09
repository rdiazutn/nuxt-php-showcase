<?php

namespace Tests\Feature\Modules\Profile;

use App\Modules\Profile\Models\ProfileQuestion;
use App\Modules\Profile\Models\CustomerProfileQuestion;
use App\Modules\Tax\Models\Tax;
use Database\Seeders\DatabaseSeeder;
use Illuminate\Http\Response;
use Tests\Feature\FeatureTestCase;

class ProfileFeatureTest extends FeatureTestCase
{
    public function testGetProfileQuestions()
    {
        $this->seed(DatabaseSeeder::class);

        $this->actingAsCustomer()
            ->graphQlQuery('profile/GetMyProfileQuestions')
            ->assertStatus(Response::HTTP_OK)
            ->assertJsonStructure([
                'data' => [
                    'me' => [
                        'taxes' => [
                            [
                                'name',
                                'profileQuestions' => [
                                    [
                                        'title'
                                    ]
                                ]
                            ]
                        ]
                    ]
                ]
            ]);
    }

    public function testAnswerInputMultipleChoiceProfileQuestion()
    {
        $this->seed(DatabaseSeeder::class);

        $question = ProfileQuestion::factory()
            ->inputMultipleChoice([
                'one' => 'One',
                'two' => 'Two'
            ])
            ->create();

        $answers = [
            [
                'profile_question_id' => $question->getKey(),
                'values' => [
                    [
                        'key' => 'one',
                        'value' => '0.52'
                    ]
                ]
            ]
        ];

        $answerId = $this->actingAsCustomer()
            ->graphQlQuery('profile/AnswerProfileQuestions', compact('answers'))
            ->assertGraphQLValidationPasses()
            ->assertJsonStructure([
                'data' => [
                    'answerProfileQuestions' => [
                        [
                            'id'
                        ]
                    ]
                ]
            ])->json('data.answerProfileQuestions.0.id');

        $answer = CustomerProfileQuestion::find($answerId);

        $this->assertEquals('0.52', $answer->getAnswer('one'));
        $this->assertNull($answer->getAnswer('two'));
    }

    public function testAnswerMultipleChoiceProfileQuestion()
    {
        $this->seed(DatabaseSeeder::class);

        $question = ProfileQuestion::factory()
            ->inputMultipleChoice([
                'one' => 'One',
                'two' => 'Two'
            ])
            ->create();

        $answers = [
            [
                'profile_question_id' => $question->getKey(),
                'selected' => ['one']
            ]
        ];

        $answerId = $this->actingAsCustomer()
            ->graphQlQuery('profile/AnswerProfileQuestions', compact('answers'))
            ->assertGraphQLValidationPasses()
            ->assertJsonStructure([
                'data' => [
                    'answerProfileQuestions' => [
                        [
                            'id'
                        ]
                    ]
                ]
            ])->json('data.answerProfileQuestions.0.id');

        $answer = CustomerProfileQuestion::find($answerId);

        $this->assertSame(['one'], $answer->getAnswer('selected'));
    }
}
