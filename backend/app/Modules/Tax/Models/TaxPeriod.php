<?php


namespace App\Modules\Tax\Models;


use App\Models\Customer;
use App\Models\Model;
use App\Models\User;
use App\Modules\IIBB\IIBBMonthly\IIBBMonthlyDeclaration;
use App\Modules\Document\Models\Document;
use App\Modules\Tax\Presentation\Models\TaxPresentation;
use BenSampo\Enum\Traits\CastsEnums;
use Illuminate\Database\Eloquent\Relations\BelongsTo;
use Illuminate\Database\Eloquent\Relations\HasMany;
use Illuminate\Database\Eloquent\Relations\HasManyThrough;
use Illuminate\Database\Eloquent\Relations\HasOne;

/**
 * Class TaxPeriod
 * @package App\Modules\Tax\Models
 * @property Customer $customer
 * @property Tax $tax
 * @property TaxPeriod $previousPeriod
 */
class TaxPeriod extends Model
{
    use CastsEnums;

    protected $casts = [
        'status' => TaxPeriodStatus::class,
        'data' => 'collection',
        'period_date' => 'date',
    ];

    protected $fillable = [
        'status',
        'data'
    ];

    public function customer(): BelongsTo
    {
        return $this->belongsTo(Customer::class);
    }

    public function tax(): BelongsTo
    {
        return $this->belongsTo(Tax::class);
    }

    public function documents(): HasMany
    {
        return $this->hasMany(Document::class);
    }

    public function presentations(): HasMany
    {
        return $this->hasMany(TaxPresentation::class);
    }

    public function presentation(): HasOne
    {
        return $this->hasOne(TaxPresentation::class)->latestOfMany();
    }

    public function previousPeriod(): HasOne
    {
        return $this->hasOne(TaxPeriod::class, 'tax_id', 'tax_id')
            ->where('customer_id', $this->customer_id)
            ->whereKeyNot($this->getKey())
            ->oldestOfMany();
    }

    public function getIIBBMonthlyDeclaration(): IIBBMonthlyDeclaration
    {
        return IIBBMonthlyDeclaration::make($this);
    }
}
