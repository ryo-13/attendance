<?php

namespace App\Http\Controllers\Front\Api;

use Carbon\Carbon;
use App\Models\User;
use App\Model\Attendance;
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
    public function index()
    {
        $dt = new Carbon;
        $daysDatas = [];
        for ($i = 1; $i <= $dt->daysInMonth; $i++) {
            $daysDatas[] = [
                'day' => $i,
                'month' => $dt->month,
                'year' => $dt->year,
                'userId' => Auth::id(),
            ];
        }

        $attendances = User::find(Auth::id())->attendances()->get();
        if ($attendances->isEmpty()) {
            $attendances = [];
            foreach ($daysDatas as $dayData) {
                $attendances[] = [
                    'arrival' => null,
                    'leave' => null,
                ];
            }
            return $attendances;
        }

        $attendances = [];
        foreach ($daysDatas as $dayData) {
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
    public function store(StoreAttendanceRequest $request)
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
    public function update(UpdateAttendanceRequest $request)
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
