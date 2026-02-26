<?php

namespace App\Models;

use Illuminate\Database\Eloquent\Model;
use Illuminate\Database\Eloquent\Relations\BelongsTo;

class Event extends Model
{
    protected $fillable = [
    'title',
    'description',
    'location',
    'event_date',
    'status',
    'rejection_reason',
    'user_id',
    'category_id',
    'banner',
];

protected $casts = [
    'event_date' => 'datetime',
];

    protected static function booted()
    {
        static::creating(function ($event) {
            $event->status = 'pendente';
        });
    }


    public function category(): BelongsTo
    {
        return $this->belongsTo(Category::class);
    }
}
