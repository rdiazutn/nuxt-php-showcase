<?php

namespace App\Models;

use App\Modules\Profile\Models\TaxProfile;
use Illuminate\Database\Eloquent\Collection;
use Illuminate\Foundation\Auth\User as Authenticatable;
use App\Modules\Document\Models\Document;
use App\Modules\Notification\Models\Notification;
use App\Modules\Profile\Models\ProfileStatus;
use App\Modules\Profile\Models\CustomerProfileQuestion;
use App\Modules\Tax\Models\Tax;
use App\Modules\Tax\Models\TaxPeriod;
use App\Modules\Tax\Models\TaxStatus;
use Illuminate\Database\Eloquent\Factories\HasFactory;
use Illuminate\Database\Eloquent\Relations\BelongsToMany;
use Illuminate\Database\Eloquent\Relations\HasMany;
use Illuminate\Database\Eloquent\Relations\HasManyThrough;
use Illuminate\Database\Eloquent\Relations\MorphMany;
use Illuminate\Notifications\Notifiable;
use Laravel\Sanctum\HasApiTokens;
use Laravel\Sanctum\NewAccessToken;
use Spatie\Permission\Traits\HasRoles;

/**
 * Class Customer
 * @package App\Models
 * @property CustomerProfileQuestion[]|Collection $profileQuestions
 * @property Tax[]|Collection $taxes
 * @property TaxPeriod[]|Collection $taxPeriods
 */
class Customer extends Authenticatable
{
    use HasApiTokens, HasFactory, Notifiable, HasRoles;

    protected $fillable = [
        'name',
        'email',
        'password',
    ];

    protected $hidden = [
        'password',
        'remember_token',
    ];

    protected $casts = [
        'email_verified_at' => 'datetime',
    ];

    protected $appends = [
        'profile_status'
    ];

    public function createUniqueToken(string $name, array $abilities = ['*']): NewAccessToken
    {
        $this->tokens()->where('name', $name)->delete();
        return $this->createToken($name, $abilities);
    }

    public function taxes(): BelongsToMany
    {
        return $this->belongsToMany(Tax::class)->withPivot('status', 'expires_at');
    }

    public function taxesWithProfileQuestions(): BelongsToMany
    {
        return $this->taxes()->with('profileQuestions.answers', fn ($qb) => $qb->where('customer_id', $this->getKey()));
    }

    public function profileQuestions(): HasMany
    {
        return $this->hasMany(CustomerProfileQuestion::class);
    }

    public function taxPeriods(): HasMany
    {
        return $this->hasMany(TaxPeriod::class);
    }

    public function documents(): HasManyThrough
    {
        return $this->hasManyThrough(Document::class, TaxPeriod::class);
    }

    public function getProfileStatusAttribute(): ProfileStatus
    {
        if ($this->taxes()->wherePivot('status', TaxStatus::AWAITING_INFO)->exists())
            return ProfileStatus::fromValue(ProfileStatus::PENDING);
        return ProfileStatus::fromValue(ProfileStatus::COMPLETED);
    }

    public function notifications(): MorphMany
    {
        return $this->morphMany(Notification::class, 'notifiable')->orderBy('created_at', 'desc');
    }

    public function getProfile(): TaxProfile
    {
        return TaxProfile::make($this);
    }

    /**
     * @param $target
     * @return bool
     */
    public function owns($target): bool
    {
        return $target->customer_id === $this->getKey();
    }
}
