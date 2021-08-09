<?php


namespace Modules\Tax;


use App\Modules\Tax\Models\TaxPeriodStatus;
use App\Modules\Tax\Presentation\Models\PaymentMethodType;
use Database\Factories\Modules\Tax\TaxPresentationFactory;
use Illuminate\Http\Response;
use Tests\Feature\FeatureTestCase;

class TaxPresentationTest extends FeatureTestCase
{
    public function testConfirmDraftPresentation()
    {
        $presentation = TaxPresentationFactory::new()->default()->create();
        $period = $presentation->taxPeriod;

        $data = [
            'periodId' => $period->getKey(),
            'input' => [
                'used_balance' => 500,
                'payment_method' => PaymentMethodType::BANK()->key
            ],
        ];

        $this->actingAsCustomer()
            ->graphQlQuery('tax/presentation/ConfirmPresentationDraft', $data)
            ->assertStatus(Response::HTTP_OK)
            ->assertJsonStructure([
                'data' => [
                    'confirmPresentationDraft'
                ]
            ]);

        $presentation->refresh();
        $this->assertEquals(500, $presentation->used_balance);
        $this->assertEquals(PaymentMethodType::BANK, $presentation->payment_method);
        $period->refresh();
        $this->assertEquals(TaxPeriodStatus::AWAITING_PRESENTATION, $period->status->value);
    }

    public function testRejectDraftPresentation()
    {
        $presentation = TaxPresentationFactory::new()->default()->create();
        $period = $presentation->taxPeriod;

        $data = [
            'periodId' => $period->getKey()
        ];

        $this->actingAsCustomer()
            ->graphQlQuery('tax/presentation/RejectPresentationDraft', $data)
            ->assertStatus(Response::HTTP_OK)
            ->assertJsonStructure([
                'data' => [
                    'rejectPresentationDraft'
                ]
            ]);

        $period->refresh();
        $this->assertEquals(TaxPeriodStatus::CREATED, $period->status->value);
    }

    public function testConfirmPresentationVoucher()
    {
        $presentation = TaxPresentationFactory::new()->withVoucher()->create();
        $period = $presentation->taxPeriod;

        $data = [
            'periodId' => $period->getKey()
        ];

        $this->actingAsCustomer()
            ->graphQlQuery('tax/presentation/ConfirmPresentationVoucher', $data)
            ->assertStatus(Response::HTTP_OK)
            ->assertJsonStructure([
                'data' => [
                    'confirmPresentationVoucher'
                ]
            ]);

        $period->refresh();
        $this->assertEquals(TaxPeriodStatus::AWAITING_APPROVAL, $period->status->value);
    }

    public function testRequestNewVoucher()
    {
        $presentation = TaxPresentationFactory::new()->withVoucher()->create();
        $period = $presentation->taxPeriod;

        $data = [
            'periodId' => $period->getKey(),
            'input' => [
                'used_balance' => 500,
                'payment_method' => PaymentMethodType::BANK()->key,
                'voucher_generation_date' => now()->addDay()->format('Y-m-d H:i:s'),
            ],
        ];

        $this->actingAsCustomer()
            ->graphQlQuery('tax/presentation/RequestNewPresentationVoucher', $data)
            ->assertStatus(Response::HTTP_OK)
            ->assertJsonStructure([
                'data' => [
                    'requestNewPresentationVoucher'
                ]
            ]);

        $presentation->refresh();
        $this->assertEquals(500, $presentation->used_balance);
        $this->assertEquals(PaymentMethodType::BANK, $presentation->payment_method);
        $this->assertEquals($data['input']['voucher_generation_date'], $presentation->voucher_generation_date);
        $period->refresh();
        $this->assertEquals(TaxPeriodStatus::AWAITING_PAYMENT, $period->status->value);
    }

    public function testRejectPresentation()
    {
        $presentation = TaxPresentationFactory::new()->withVoucher()->create();
        $period = $presentation->taxPeriod;

        $data = [
            'periodId' => $period->getKey()
        ];

        $this->actingAsCustomer()
            ->graphQlQuery('tax/presentation/RejectPresentation', $data)
            ->assertStatus(Response::HTTP_OK)
            ->assertJsonStructure([
                'data' => [
                    'rejectPresentation'
                ]
            ]);

        $period->refresh();
        $this->assertEquals(TaxPeriodStatus::AWAITING_RECTIFICATION, $period->status->value);
    }
}
