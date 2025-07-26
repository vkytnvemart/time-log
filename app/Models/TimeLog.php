<?php

namespace App\Models;

use Illuminate\Database\Eloquent\Model;

class TimeLog extends Model
{
    protected $fillable = ['work_date', 'description', 'hours', 'minutes'];

    protected $casts = [
        'work_date' => 'date', // <-- this line ensures it's a Carbon object
    ];
}
