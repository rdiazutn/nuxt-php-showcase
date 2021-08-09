<?php

namespace App\Modules\Document\Models;

use App\Models\Model;
use App\Models\User;
use App\Modules\File\Models\File;
use App\Modules\Tax\Models\TaxPeriod;
use Illuminate\Database\Eloquent\Concerns\HasTimestamps;
use Illuminate\Database\Eloquent\Factories\HasFactory;
use Illuminate\Database\Eloquent\Relations\BelongsTo;
use Illuminate\Database\Eloquent\Relations\HasOneThrough;

class Document extends Model
{
    use HasFactory, HasTimestamps;

    public function user(): HasOneThrough
    {
        return $this->hasOneThrough(User::class, TaxPeriod::class);
    }

    public function file(): BelongsTo
    {
        return $this->belongsTo(File::class);
    }

    public function taxPeriod(): BelongsTo
    {
        return $this->belongsTo(TaxPeriod::class);
    }
}
