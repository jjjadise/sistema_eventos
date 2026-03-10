<?php

namespace App\Models;

use Illuminate\Database\Eloquent\Model;
use Illuminate\Database\Eloquent\Factories\HasFactory;

class Event extends Model
{
    use HasFactory;

    protected $fillable = [
        'title',
        'description',
        'event_date',
        'location',
        'address',
        'modality',
        'event_link',
        'is_paid',
        'has_interpreter',
        'banner',
        'banner_alt_text',
        'status',
        'category_id',
        'campus_id',
        'knowledge_area_id',
        'responsible_name',
        'responsible_phone',
        'responsible_email',
        'is_accessible',
        'registration_link',
        'submission_date',
        'rejection_reason',
        
    ];

    public function category()
    {
        return $this->belongsTo(Category::class);
    }

    public function campus()
    {
        return $this->belongsTo(Campus::class);
    }

    public function knowledgeArea()
    {
        return $this->belongsTo(KnowledgeArea::class);
    }
}