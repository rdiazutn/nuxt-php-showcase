<?php


namespace App\Modules\Notification\Models;


use Illuminate\Database\Eloquent\Builder;
use Illuminate\Notifications\DatabaseNotification;

class Notification extends DatabaseNotification
{
    protected $dates = [
        'bookmarked_at'
    ];

    function scopeBookmarked(Builder $qb, ?bool $value = true): Builder
    {
        return $qb
            ->when($value, fn ($qb) => $qb->whereNotNull('bookmarked_at'))
            ->when(!$value, fn ($qb) => $qb->whereNull('bookmarked_at'));
    }

    function scopeRead(Builder $qb, bool $value = true): Builder
    {
        return $qb
            ->when($value, fn ($qb) => $qb->whereNotNull('read_at'))
            ->when(!$value, fn ($qb) => $qb->whereNull('read_at'));
    }

    function getReadAttribute(): bool
    {
        return $this->read();
    }

    function setReadAttribute(bool $value)
    {
        $this->read_at = $value? now() : null;
    }

    function getBookmarkedAttribute(): bool
    {
        return $this->bookmarked_at !== null;
    }

    function setBookmarkedAttribute(bool $value)
    {
        $this->bookmarked_at = $value? now() : null;
    }

    function getTitleAttribute(): ?string
    {
        return $this->data['title'] ?? null;
    }

    function getBodyAttribute(): ?string
    {
        return $this->data['body'] ?? null;
    }
}
