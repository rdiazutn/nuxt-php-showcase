<?php


namespace App\Modules\Tax\Permission;


class TaxPermission
{
    const REJECT_TAX_PERIOD_DRAFT = 'TaxPeriod.Draft.Reject';
    const CONFIRM_TAX_PERIOD_DRAFT = 'TaxPeriod.Draft.Confirm';
    const CONFIRM_TAX_PERIOD_VOUCHER = 'TaxPeriod.Voucher.Confirm';
    const REJECT_TAX_PERIOD_VOUCHER = 'TaxPeriod.Voucher.Reject';
    const REJECT_TAX_PRESENTATION = 'TaxPeriod.Presentation.Reject';
}
