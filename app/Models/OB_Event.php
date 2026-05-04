<?php

namespace App\Models;

use Illuminate\Database\Eloquent\Model;

class OB_Event extends Model
{
    protected $table = 'ob_events';

    protected $fillable = [
        'title',
        'description',
        'start_date',
        'end_date',
        'place',
        'price',
        'category_id',
        'capacity',
        'image',
        'created_by',
        'is_free',
    ];

    protected $casts = [
        'start_date' => 'datetime',
        'end_date'   => 'datetime',
        'is_free'    => 'boolean',
    ];

    /* ================= RELATIONS ================= */

    // Event belongsTo User
    public function user()
    {
        return $this->belongsTo(User::class, 'created_by');
    }

    // Event belongsTo Category
    public function category()
    {
        return $this->belongsTo(OB_Category::class, 'category_id');
    }

    // Event hasMany Registration
    public function registrations()
    {
        return $this->hasMany(OB_Registration::class, 'event_id');
    }
}
