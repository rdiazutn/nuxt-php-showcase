<?php

namespace App\Modules\File\Models;

use App\Models\Model;
use Illuminate\Database\Eloquent\Concerns\HasTimestamps;
use Illuminate\Database\Eloquent\Factories\HasFactory;
use Illuminate\Support\Facades\Storage;

class File extends Model
{
    use HasFactory, HasTimestamps;

    public function getUrlAttribute(): string
    {
        return Storage::url($this->path);
    }
}
