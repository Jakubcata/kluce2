<?php

namespace App;

use Illuminate\Database\Eloquent\Model;
use Illuminate\Database\Eloquent\SoftDeletes;

class Key extends Model
{
    use SoftDeletes;

    protected $fillable = [
        'name','reason', 'booked_until','color','group',
    ];

    public function owner()
    {
        return $this->belongsTo(Owner::class);
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
