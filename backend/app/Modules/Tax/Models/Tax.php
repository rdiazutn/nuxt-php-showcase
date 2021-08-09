<?php


namespace App\Modules\Tax\Models;


use App\Models\Customer;
use App\Models\Model;
use App\Modules\Profile\Models\ProfileQuestion;
use Database\Factories\Modules\Tax\Models\TaxFactory;
use Illuminate\Database\Eloquent\Collection;
use Illuminate\Database\Eloquent\Relations\BelongsToMany;
use Illuminate\Database\Eloquent\Relations\HasMany;
use Illuminate\Support\Carbon;


/**
 * Class Tax
 * @package App\Modules\Tax\Models
 *
 * @method static TaxFactory factory()
 * @property ProfileQuestion[]|Collection $profileQuestions
 */
class Tax extends Model
{
    public function profileQuestions(): BelongsToMany
    {
        return $this->belongsToMany(ProfileQuestion::class);
    }

    public function customers(): BelongsToMany
    {
        return $this->belongsToMany(Customer::class);
    }

    public function periods(): HasMany
    {
        return $this->HasMany(TaxPeriod::class);
    }

    public function getStatusAttribute()
    {
        return TaxStatus::fromValue($this->pivot->status);
    }

    public function getExpiresAtAttribute(): ?Carbon
    {
        return Carbon::make($this->pivot->expires_at);
    }

    public function getProfileQuestions()
    {
        return [
            'activities' => new ActivitiesQuestion(),
            new RegionsQuestion(),
            new RegionsQuestion(),
        ];
    }
}
