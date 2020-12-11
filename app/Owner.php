<?php

namespace App;

use Illuminate\Database\Eloquent\Model;
use Illuminate\Database\Eloquent\SoftDeletes;

class Owner extends Model
{
    use SoftDeletes;

    protected $fillable = [
        'id', 'name', 'surname', 'phone', 'facebook'
    ];

    public function key()
    {
        return $this->hasOne(Key::class);
    }

    public function group()
    {
        return $this->belongsTo(Group::class);
    }

    public function history()
    {
        return $this->hasMany(History::class);
    }
}
