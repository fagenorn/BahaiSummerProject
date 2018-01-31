<?php

namespace App;

use Illuminate\Database\Eloquent\Model;


class Participant extends Model
{
    /**
     * The attributes that are mass assignable.
     *
     * @var array
     */
    protected $fillable = [
        'group_id', 'first_name', 'last_name', 'dob', 'gender', 'language', 'diet', 'acc_type', 'acc_single_room', 'acc_free_parent', 'full_stay', 'arrival_date', 'arrival_meal', 'departure_date', 'departure_meal',
    ];

    public function groupId()
    {
        return $this->belongsTo(Group::class, 'group_id', 'id');
    }
}
