<?php

namespace App\Models;

use Illuminate\Database\Eloquent\Model;
use App\Models\Overtime;

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
    ];

    /**
     * @return \Illuminate\Database\Eloquent\Relations\HasOne
     */
    public function overtime()
    {
        return $this->hasOne(Overtime::class);
    }
}
