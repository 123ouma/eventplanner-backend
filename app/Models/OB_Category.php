<?php

namespace App\Models;

use Illuminate\Database\Eloquent\Model;

class OB_Category extends Model
{
    protected $table = 'ob_categories';

    protected $fillable = ['name'];

    /* ================= RELATIONS ================= */

    // Category hasMany Event
    public function events()
    {
        return $this->hasMany(OB_Event::class, 'category_id');
    }
}
