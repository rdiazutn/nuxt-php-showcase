<?php


namespace App\Modules\Tax\Presentation\Models;


use BenSampo\Enum\Enum;

class PaymentMethodType extends Enum
{
    const BANK = 'Bank';
    const MERCADO_PAGO = 'MercadoPago';
    const RED_LINK = 'RedLink';
    const PAGO_MIS_CUENTAS = 'PagoMisCuentas';
}
