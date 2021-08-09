<?php


namespace App\Modules\Tax\Models;


use BenSampo\Enum\Enum;

class TaxPeriodStatus extends Enum
{
    const CREATED = 'Created';
    const PRESENTATION_VALIDATION = 'PresentationValidation';
    const DRAFT_VALIDATION = 'DraftValidation';
    const AWAITING_PRESENTATION = 'AwaitingPresentation';
    // With Presentation
    const AWAITING_PAYMENT = 'AwaitingPayment';
    const AWAITING_APPROVAL = 'AwaitingApproval';
    const AWAITING_VOUCHER = 'AwaitingVoucher';
    const CLOSED = 'Closed';
    // Rectification
    const AWAITING_RECTIFICATION = 'AwaitingRectification';

    /**
     * @return string[]
     */
    public static function withPresentation(): array
    {
        return [
            self::AWAITING_PAYMENT,
            self::AWAITING_APPROVAL,
            self::AWAITING_VOUCHER,
            self::CLOSED
        ];
    }
}
