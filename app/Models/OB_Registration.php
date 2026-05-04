<?php

namespace App\Models;

use Illuminate\Database\Eloquent\Model;

class OB_Registration extends Model
{
    protected $table = 'ob_registrations'; 

    protected $fillable = [
        'user_id',
        'event_id',
    ];

    /* ================= RELATIONS ================= */

    public function user()
    {
        return $this->belongsTo(User::class);
    }

    public function event()
    {
        return $this->belongsTo(OB_Event::class, 'event_id');
    }
}
