<?php

namespace App;

use Illuminate\Database\Eloquent\Model;


class Group extends Model
{
    /**
     * The attributes that are mass assignable.
     *
     * @var array
     */
    protected $fillable = [
        'last_name', 'address', 'email', 'phone'
    ];

    public function users()
    {
        return $this->hasMany(Participant::class, 'group_id', 'id');
    }
}
