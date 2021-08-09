<?php


namespace Tests\Feature\Modules\Tax;


use Database\Seeders\DatabaseSeeder;
use Database\Seeders\TaxProfileSeeder;
use Illuminate\Http\Response;
use Tests\Feature\FeatureTestCase;

class TaxFeatureTest extends FeatureTestCase
{
    public function testGetMyTaxPeriods()
    {
        $this->seed(DatabaseSeeder::class);
        $this->seed(TaxProfileSeeder::class);

        $filters = [
            'first' => 10,
            'page' => 1,
        ];

        $this->actingAsCustomer()
            ->graphQlQuery('tax/GetMyTaxPeriods', $filters)
            ->assertStatus(Response::HTTP_OK)
            ->assertJsonStructure([
                'data' => [
                    'me' => [
                        'taxPeriods' => [
                            'data' => [
                                [
                                    'IIBBMonthlyDeclaration' => [
                                        'billing',
                                        'not_invoiced',
                                        'not_income',
                                        'deductions',
                                    ]
                                ]
                            ]
                        ]
                    ]
                ]
            ]);
    }

    public function testAnswerIIBBMonthlyDeclaration()
    {
        $this->seed(DatabaseSeeder::class);
        $this->seed(TaxProfileSeeder::class);
        $period = $this->getCustomer()->taxPeriods[0];

        $data = [
            'periodId' => $period->getKey(),
            'input' => [
                'not_invoiced' => [
                    'concepts' => [
                        [
                            'key' => "PlazoFijo",
                            'value' => "1234"
                        ]
                    ],
                    'extra' => []
                ],
                'billing' => [
                    'activities' => [
                        [
                            'key' => "9",
                            'regions' => [
                                [
                                    'key' => "BA",
                                    'value' => 100,
                                    'iva' => 21
                                ]
                            ]
                        ]
                    ]
                ]
            ]
        ];

        $this->actingAsCustomer()
            ->graphQlQuery('tax/AnswerMyIIBBMonthlyDeclaration', $data)
            ->assertStatus(Response::HTTP_OK)
            ->assertJsonStructure([
                'data' => [
                    'answerIIBBMonthlyDeclaration'
                ]
            ]);

        $period->refresh();
        $declaration = $period->getIIBBMonthlyDeclaration();
        $this->assertEquals(1234, data_get($declaration, 'not_invoiced.concepts.PlazoFijo.value'));
        $this->assertEquals(100, data_get($declaration, 'billing.activities.0.regions.BA.value'));
        $this->assertEquals(21, data_get($declaration, 'billing.activities.0.regions.BA.iva'));
    }
}
