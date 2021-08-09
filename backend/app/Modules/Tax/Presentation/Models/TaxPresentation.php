<?php


namespace App\Modules\Tax\Presentation\Models;


use App\Models\Model;
use App\Modules\File\Models\File;
use App\Modules\Tax\Models\TaxPeriod;
use BenSampo\Enum\Traits\CastsEnums;
use Illuminate\Database\Eloquent\Relations\BelongsTo;

class TaxPresentation extends Model
{
    use CastsEnums;

    protected $casts = [
        'payment_method' => PaymentMethodType::class,
        'expiration_date' => 'date',
        'generation_date' => 'date',
    ];

    protected $fillable = [
        'used_balance',
        'payment_method',
        'voucher_generation_date',
    ];

    public function taxPeriod(): BelongsTo
    {
        return $this->belongsTo(TaxPeriod::class);
    }

    public function draft(): BelongsTo
    {
        return $this->belongsTo(File::class);
    }

    public function presentation(): BelongsTo
    {
        return $this->belongsTo(File::class);
    }

    public function voucher(): BelongsTo
    {
        return $this->belongsTo(File::class);
    }
}
