<?php

namespace App\Http\Controllers\Front\Api;

use Carbon\Carbon;
use Carbon\CarbonPeriod;
use App\Models\Attendance;
use App\Http\Controllers\Controller;
use Illuminate\Support\Facades\Auth;
use App\Http\Requests\Front\API\AttendanceStoreRequest;
use App\Http\Requests\Front\API\AttendanceLeaveUpdateRequest;
use App\Http\Requests\Front\API\AttendanceArrivalUpdateRequest;

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
        $startOfMonth = $dt->now()->startOfMonth();
        $endOfMonth = $dt->now()->endOfMonth();

        $currentMonthPeriod = CarbonPeriod::create($startOfMonth, $endOfMonth);

        $attendances = Auth::user()->attendances()->get();
        if ($attendances->isEmpty()) {
            $attendances = [];

            foreach ($currentMonthPeriod as $currentMonthDay) {
                $attendances[] = [
                    'arrival' => null,
                    'leave' => null,
                    'day_of_week' => $currentMonthDay->isoFormat('ddd'),
                ];
            }
            return $attendances;
        }

        $attendances = [];
        foreach ($currentMonthPeriod as $currentMonthDay) {
            $attendances[] = Auth::user()->attendances()->where('date', $currentMonthDay)->first();
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
        $attendances = [];
        foreach ($request->displayDaysData as $key => $value) {
            $day = $key + 1;
            $attendances[] = Attendance::create([
                'user_id' => Auth::id(),
                'date' =>  "{$dt->year}-{$dt->month}-{$day}",
                'arrival' => $value['arrival'],
                'leave' => $value['leave'],
                'day_of_week' => $value['day_of_week'],
            ]);
        }

        return $attendances;
    }

    /**
     * 出社時間を更新
     *
     * @param UpdateAttendanceRequest $request
     */
    public function updateArrival(AttendanceArrivalUpdateRequest $request, Attendance $attendance)
    {
        return  $attendance->update([
            'arrival' => $request->attendanceTime['arrival']
        ]);
    }

    /**
     * 退社時間を更新
     *
     * @param UpdateAttendanceRequest $request
     */
    public function updateLeave(AttendanceLeaveUpdateRequest $request, Attendance $attendance)
    {
        return $attendance->update([
            'leave' => $request->attendanceTime['leave']
        ]);
    }

    /**
     * 出社時間をリセット
     *
     * @param Attendance $attendance
     * @return void
     */
    public function resetArrival(Attendance $attendance)
    {
        return $attendance->update([
            'arrival' => null
        ]);
    }

    /**
     * 退社時間をリセット
     *
     * @param Attendance $attendance
     * @return void
     */
    public function resetLeave(Attendance $attendance)
    {
        return $attendance->update([
            'leave' => null
        ]);
    }
}
