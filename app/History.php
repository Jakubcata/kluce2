<?php

namespace App;

use Illuminate\Database\Eloquent\Model;

class History extends Model
{
    protected $fillable = [
        'start_time', 'end_time', 'needed_date','reason',
    ];

    public function owner()
    {
        return $this->belongsTo(Owner::class);
    }

    public function key()
    {
        return $this->belongsTo(Key::class);
    }
}
