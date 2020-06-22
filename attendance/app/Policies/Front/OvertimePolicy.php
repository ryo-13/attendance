<?php

namespace App\Policies\Front;

use Illuminate\Auth\Access\HandlesAuthorization;
use App\Models\User;
use App\Models\Overtime;
use App\Models\Attendance;

class OvertimePolicy
{
    use HandlesAuthorization;

    /**
     * @param User $user
     * @param Overtime $overtime
     * @return boolean
     */
    public function delete(User $user, Overtime $overtime)
    {
        return $user->id === Attendance::find($overtime->attendance_id)->user_id;
    }
}
