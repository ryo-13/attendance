<?php

namespace App\Http\Controllers\Front\Api;

use Carbon\Carbon;
use App\Models\User;
use App\Model\Attendance;
use Illuminate\Support\Facades\Log;
use App\Http\Controllers\Controller;
use Illuminate\Support\Facades\Auth;
use App\Http\Requests\Front\API\StoreAttendanceRequest;
use App\Http\Requests\Front\API\UpdateAttendanceRequest;

class AttendanceController extends Controller
{
    /**
     * Undocumented function
     *
     * @return void
     */
    public function getAttendances()
    {
        Log::debug('docker in dockers');
        $dt = new Carbon;
        $daysData = [];
        for ($i = 1; $i <= $dt->daysInMonth; $i++) {
            $daysData[] = [
                'day' => $i,
                'month' => $dt->month,
                'year' => $dt->year,
                'userId' => Auth::id(),
            ];
        }

        $attendances = User::find(Auth::id())->attendances()->get();
        if ($attendances->isEmpty()) {
            $attendances = [];
            foreach ($daysData as $dayData) {
                $attendances[] = [
                    'arrival' => null,
                    'leave' => null,
                ];
            }
            return $attendances;
        }

        $attendances = [];
        foreach ($daysData as $dayData) {
            $date = $dayData['year'] . '-' . $dayData['month'] . '-' . $dayData['day'];
            $attendances[] = User::find(Auth::id())->attendances()->where('date', $date)->first();
        }
        return $attendances;
    }

    /**
     * Undocumented function
     *
     * @param StoreAttendanceRequest $request
     * @return void
     */
    public function storeAttendances(StoreAttendanceRequest $request)
    {
        $dt = new Carbon;
        foreach ($request->displayDaysData as $key => $value) {
            Attendance::create([
                'user_id' => Auth::id(),
                'date' => $dt->year . $dt->month  . ($key + 1),
                'arrival' => $value['arrival'],
                'leave' => $value['leave']
            ]);
        }
    }

    /**
     * Undocumented function
     *
     * @param UpdateAttendanceRequest $request
     * @return void
     */
    public function updateAttendances(UpdateAttendanceRequest $request)
    {
        $dt = new Carbon;
        foreach ($request->displayDaysData as $key => $value) {
            $dates = $dt->year . '-' . $dt->month . '-' . ($key + 1);
            Attendance::where('user_id', Auth::id())->where('date', $dates)->update([
                'arrival' => $value['arrival'],
                'leave' => $value['leave']
            ]);
        }
    }
}
