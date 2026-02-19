<?php

namespace App\Models;

use Illuminate\Database\Eloquent\Model;

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
    ];

    protected static function booted()
    {
        static::creating(function ($event) {
            $event->status = 'pendente';
        });
    }
}
