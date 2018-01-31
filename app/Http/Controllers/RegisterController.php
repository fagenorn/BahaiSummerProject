<?php

namespace App\Http\Controllers;

use App\Group;
use App\Participant;
use Illuminate\Http\Request;
use Illuminate\Support\Facades\Validator;
use Illuminate\Validation\Rule;

class RegisterController extends Controller
{
    public function create()
    {
        return view('index');
    }

    public function store(Request $request)
    {
        $request->validate([
            'last_name' => 'required|alpha',
            'address' => 'required',
            'email' => 'required|email',
            'phone' => 'required|phone',
        ]);

        foreach ($request->rows as $row) {
            /** @noinspection PhpUnhandledExceptionInspection */
            Validator::make($row, [
                'first_name' => 'required',
                'last_name' => 'required',
                'dob' => 'required|date_format:"Y-m-d"|before:today|after:120 years ago',
                'gender' => ['required', Rule::in(['0', '1'])],
                'language' => ['required', Rule::in(['0', '1', '2'])],
                'diet' => ['required', Rule::in(['0', '1', '2', '3'])],
                'acc_type' => ['required', Rule::in(['0', '1', '2'])],
                'acc_single_room' => 'required|boolean',
                'acc_free_parent' => 'required|boolean|free_child:dob',
                'full_stay' => 'required|boolean',
                'arrival_date' => 'required_if:full_stay,0|nullable|date_format:"Y-m-d"|before_or_equal:departure_date|after_or_equal:2018-07-06',
                'arrival_meal' => ['required_if:full_stay,0', Rule::in(['0', '1', '2'])],
                'departure_date' => 'required_if:full_stay,0|nullable|date_format:"Y-m-d"|after_or_equal:arrival_date|before_or_equal:2018-07-10',
                'departure_meal' => ['required_if:full_stay,0', Rule::in(['0', '1', '2'])],
            ])->validate();
        }

        $group = Group::create([
            'last_name' => $request->input('last_name'),
            'address' => $request->input('address'),
            'email' => $request->input('email'),
            'phone' => $request->input('phone'),
        ]);

        foreach ($request->rows as $row) {
            Participant::create([
                'group_id' => $group->id,
                'first_name' => $row['first_name'],
                'last_name' => $row['last_name'],
                'dob' => $row['dob'],
                'gender' => $row['gender'],
                'language' => $row['language'],
                'diet' => $row['diet'],
                'acc_type' => $row['acc_type'],
                'acc_single_room' => $row['acc_single_room'],
                'acc_free_parent' => $row['acc_free_parent'],
                'full_stay' => $row['full_stay'],
                'arrival_date' => isset($row['arrival_date']) ? $row['arrival_date'] : null,
                'arrival_meal' => isset($row['arrival_meal']) ? $row['arrival_meal'] : null,
                'departure_date' => isset($row['departure_date']) ? $row['departure_date'] : null,
                'departure_meal' => isset($row['departure_meal']) ? $row['departure_meal'] : null,
            ]);
        }

        return view('success');
    }
}
