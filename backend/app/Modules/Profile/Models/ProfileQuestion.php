<?php


namespace App\Modules\Profile\Models;


use App\GraphQL\Mutations\AnswerProfileQuestions;
use App\Models\Model;
use App\Modules\Tax\Models\Tax;
use BenSampo\Enum\Traits\CastsEnums;
use Database\Factories\Modules\Profile\Models\ProfileQuestionFactory;
use Illuminate\Database\Eloquent\Collection;
use Illuminate\Database\Eloquent\Concerns\HasTimestamps;
use Illuminate\Database\Eloquent\Relations\BelongsToMany;
use Illuminate\Database\Eloquent\Relations\HasMany;

/**
 * Class ProfileQuestion
 * @package App\Modules\Profile\Models
 * @property ProfileQuestionType $type
 * @property \Illuminate\Support\Collection $data
 * @property Collection|AnswerProfileQuestions[] $answers
 * @method static ProfileQuestionFactory factory($attr = [])
 */
class ProfileQuestion extends Model
{
    use HasTimestamps, CastsEnums;

    protected $casts = [
        'data' => 'collection',
        'type' => ProfileQuestionType::class
    ];

    public function answers(): HasMany
    {
        return $this->hasMany(CustomerProfileQuestion::class);
    }

    public function taxes(): BelongsToMany
    {
        return $this->belongsToMany(Tax::class);
    }

    public function getQuestionAttribute(): array
    {
        return $this->type->mapData($this->data, $this->answers->first());
    }

    public function getRulesAttribute(): \Illuminate\Support\Collection
    {
        return collect($this->data->get('rules'))
            ->map(fn ($rule) => $rule['attributes']);
    }
}
