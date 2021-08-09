<?php


namespace App\Modules\Profile\Models;


use App\Models\Customer;
use App\Models\Model;
use App\Models\User;
use Illuminate\Database\Eloquent\Relations\BelongsTo;
use Illuminate\Database\Eloquent\SoftDeletes;
use Illuminate\Support\Collection;

/**
 * Class CustomerProfileQuestion
 * @package App\Modules\Profile\Models
 * @property Collection $answer
 */
class CustomerProfileQuestion extends Model
{
    use SoftDeletes;

    protected $casts = [
        'answer' => 'collection'
    ];

    protected $fillable = [
        'answer',
        'customer_id',
        'profile_question_id'
    ];

    public function profileQuestion(): BelongsTo
    {
        return $this->belongsTo(ProfileQuestion::class);
    }

    public function customer(): BelongsTo
    {
        return $this->belongsTo(Customer::class);
    }

    public function getAnswer(string $key = null)
    {
        return $key? $this->answer->get($key) : $this->answer;
    }
}
