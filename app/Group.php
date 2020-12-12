<?php

namespace App;

use Illuminate\Database\Eloquent\Model;
use Illuminate\Database\Eloquent\SoftDeletes;

class Group extends Model
{
    use SoftDeletes;

    protected $fillable = [
        'name',
    ];

    public function owners()
    {
        return $this->hasMany(Owner::class);
    }

    public function keys()
    {
        return $this->hasMany(Key::class);
    }
}
