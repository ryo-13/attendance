<?php

namespace App\Http\Controllers\Front\Api;

use Carbon\Carbon;
use App\Models\User;
use App\Model\Attendance;
use Illuminate\Support\Facades\Log;
use App\Http\Controllers\Controller;
use Illuminate\Support\Facades\Auth;
use App\Http\Requests\Front\API\AttendanceStoreRequest;
use App\Http\Requests\Front\API\AttendanceUpdateRequest;

class AttendanceController extends Controller
{
    /**
     * 出退勤情報を取得
     *
     * @return array
     */
    public function getAttendances()
    {
        $dt = new Carbon;
        $days = [];
        for ($i = 1; $i <= $dt->daysInMonth; $i++) {
            $days[] = $i;
        }

        $attendances = User::find(Auth::id())->attendances()->get();
        if ($attendances->isEmpty()) {
            $attendances = [];
            foreach ($days as $day) {
                $attendances[] = [
                    'arrival' => null,
                    'leave' => null,
                ];
            }
            return $attendances;
        }

        $attendances = [];
        foreach ($days as $day) {
            $date = "{$dt->year}-{$dt->month}-{$day}";
            $attendances[] = User::find(Auth::id())->attendances()->where('date', $date)->first();
        }
        return $attendances;
    }

    /**
     * 出退勤情報を作成
     *
     * @param StoreAttendanceRequest $request
     */
    public function storeAttendances(AttendanceStoreRequest $request)
    {
        $dt = new Carbon;
        foreach ($request->displayDaysData as $key => $value) {
            $day = $key + 1;
            Attendance::create([
                'user_id' => Auth::id(),
                'date' =>  "{$dt->year}-{$dt->month}-{$day}",
                'arrival' => $value['arrival'],
                'leave' => $value['leave']
            ]);
        }
    }

    /**
     * 出退勤情報を更新
     *
     * @param UpdateAttendanceRequest $request
     */
    public function updateAttendances(AttendanceUpdateRequest $request)
    {
        $dt = new Carbon;
        foreach ($request->displayDaysData as $key => $value) {
            $day = $key + 1;
            $dates = "{$dt->year}-{$dt->month}-{$day}";
            Log::debug($dates);
            Attendance::where('user_id', Auth::id())->where('date', $dates)->update([
                'arrival' => $value['arrival'],
                'leave' => $value['leave']
            ]);
        }
    }
}
