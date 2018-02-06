<?php

namespace App;

use Carbon\Carbon;
use DateTime;
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

    private $full_prices_standard = [
        "13" => 190,
        "6" => 133,
        "3" => 95,
        "0" => 0,
    ];

    private $partial_prices_standard = [
        "13" => 50,
        "6" => 35,
        "3" => 25,
        "0" => 0,
    ];

    private $full_prices_deluxe = [
        "13" => 300,
        "6" => 210,
        "3" => 150,
        "0" => 0,
    ];

    private $partial_prices_deluxe = [
        "13" => 80,
        "6" => 64,
        "3" => 40,
        "0" => 0,
    ];

    private $no_acc_prices = [
        "13" => 6,
        "6" => 6,
        "3" => 6,
        "0" => 0,
    ];

    private $lunch_prices = [
        "13" => 9,
        "6" => 7,
        "3" => 6,
        "0" => 0,
    ];

    private $dinner_prices = [
        "13" => 12,
        "6" => 9,
        "3" => 7.20,
        "0" => 0,
    ];

    public function groupId()
    {
        return $this->belongsTo(Group::class, 'group_id', 'id');
    }

    public function getPriceAttribute()
    {
        $age = $this->age;
        switch (true) {
            case in_array($age, range(0, 2)): //the range from range of 0-20
                $age_type = "0";
                break;
            case in_array($age, range(3, 5)): //range of 21-40
                $age_type = "3";
                break;
            case in_array($age, range(6, 12)): //range of 21-40
                $age_type = "6";
                break;
            default: //range of 21-40
                $age_type = "13";
                break;
        }

        if ($this->full_stay) {
            if ($this->acc_type == 0) {
                // Standard
                return $this->full_prices_standard[$age_type];
            } else if ($this->acc_type == 1) {
                // Deluxe
                return $this->full_prices_deluxe[$age_type];
            } else {
                // No accommodation
                $price_stay = $this->no_acc_prices[$age_type];

                // Remove one, because last night not sleeping
                $total_stay_price = ($this->total_days - 1) * $price_stay;
                return $total_stay_price + $this->total_meal_price;
            }
        }

        if ($this->acc_type == 0) {
            // Standard
            // Remove one, because last night not sleeping
            return ($this->partial_prices_standard[$age_type] * $this->total_days - 1) + $this->total_meal_price;
        } else if ($this->acc_type == 1) {
            // Deluxe
            return ($this->partial_prices_deluxe[$age_type] * $this->total_days - 1) + $this->total_meal_price;
        } else {
            // No accommodation
            $price_stay = $this->no_acc_prices[$age_type];

            // Remove one, because last night not sleeping
            $total_stay_price = ($this->total_days - 1) * $price_stay;
            return $total_stay_price + $this->total_meal_price;
        }
    }

    public function getAgeAttribute()
    {
        return Carbon::parse($this->dob)->age;
    }

    public function getTotalDaysAttribute()
    {
        if (is_null($this->arrival_date)) {
            return \Config::get('constants.total_days');
        }

        $datetime1 = new DateTime($this->arrival_date);
        $datetime2 = new DateTime($this->departure_date);
        return $datetime1->diff($datetime2)->days;
    }

    public function getTotalMealsAttribute()
    {
        $total_lunch = 0;
        $total_dinner = 0;
        $days = $this->total_days;

        if ($this->full_stay) {
            // Since arrival_meal and departure_meal are not set.
            $total_lunch += 2;
            $total_dinner += 2;
        }

        if ($days > 2) {
            // Add two meals per day, except for first and last
            $total_lunch += ($days - 2);
            $total_dinner += ($days - 2);
        }

        switch ($this->arrival_meal) {
            case 0:
                // Before lunch
                $total_lunch += 1;
                $total_dinner += 1;
                break;
            case 1:
                // Before dinner
                $total_lunch += 1;
                break;
        }

        switch ($this->departure_meal) {
            case 1:
                // Before dinner
                $total_lunch += 1;
                break;
            case 2:
                // After dinner
                $total_lunch += 1;
                $total_dinner += 1;
                break;
        }

        return ['lunch' => $total_lunch, 'dinner' => $total_dinner];
    }

    public function getTotalMealPriceAttribute()
    {
        $age = $this->age;
        switch (true) {
            case in_array($age, range(0, 2)): //the range from range of 0-20
                $age_type = "0";
                break;
            case in_array($age, range(3, 5)): //range of 21-40
                $age_type = "3";
                break;
            case in_array($age, range(6, 12)): //range of 21-40
                $age_type = "6";
                break;
            default: //range of 21-40
                $age_type = "13";
                break;
        }

        $price_lunch = $this->lunch_prices[$age_type];
        $price_dinner = $this->dinner_prices[$age_type];

        return ($this->total_meals['lunch'] * $price_lunch) + ($this->total_meals['dinner'] * $price_dinner);
    }
}
