<?php

namespace App\Models;

use App\Models\User;
use Illuminate\Database\Eloquent\Model;

class Attendance extends Model
{
    /**
     * @var array
     */
    protected $fillable = [
        'user_id',
        'date',
        'arrival',
        'leave',
        'day_of_week',
    ];

    /**
     * @return \Illuminate\Database\Eloquent\Relations\HasOne
     */
    public function overtime()
    {
        return $this->hasOne(Overtime::class);
    }

    public function user()
    {
        return $this->belongsTo(User::class);
    }
}
