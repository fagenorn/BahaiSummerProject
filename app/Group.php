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

    public function getInvoiceNumberAttribute()
    {
        return "EE/ZS/" . \Carbon\Carbon::now()->format('Y') . "-" . $this->id;
    }

    public function getTotalPriceAttribute()
    {
        $total = 0;
        foreach ($this->users as $user) {
            $total += $user->price;
        }
        return $total - $this->reduction;
    }

    public function getDuePriceAttribute()
    {
        return $this->total_price - $this->paid;
    }
}
