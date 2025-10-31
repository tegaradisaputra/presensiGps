<?php

namespace App\Models;

use Illuminate\Database\Eloquent\Model;

class Attendance extends Model
{
    //
    protected $table = 'attendances';

    protected $fillable = [
        'nik',
        'attendance_date',
        'time_in',
        'time_out',
        'photo_in',
        'photo_out',
        'location'
];

}
