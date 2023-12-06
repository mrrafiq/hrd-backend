<?php

namespace App\Models\Employee;

use Illuminate\Database\Eloquent\Factories\HasFactory;
use Illuminate\Database\Eloquent\Model;

class Employee extends Model
{
    use HasFactory;

    protected $fillable = [
        'user_id',
        'phone_number',
        'date_of_birth',
        'place_of_birth',
        'address',
    ];

    protected $hidden = [
        'user_id'
    ];
}
