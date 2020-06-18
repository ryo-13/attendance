<?php

namespace App\Models;

use Illuminate\Database\Eloquent\Model;

class Overtime extends Model
{
    /**
     * @var array
     */
    protected $fillable = [
        'attendance_id',
        'overtime',
        'overtime_reason',
        'is_permitted',
    ];
}
