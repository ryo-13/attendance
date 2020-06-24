<?php

namespace App\Http\Controllers\Front\Api;

use Carbon\Carbon;
use App\Models\User;
use Carbon\CarbonPeriod;
use App\Models\Attendance;
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
        $startOfMonth = $dt->now()->startOfMonth();
        $endOfMonth = $dt->now()->endOfMonth();

        $startOrEndOfMonth = CarbonPeriod::create($startOfMonth, $endOfMonth)->days();

        $daysOfWeekForMonth = [];
        foreach ($startOrEndOfMonth as $date) {
            $daysOfWeekForMonth[] =  $date->isoFormat('ddd');
        }

        $attendances = User::find(Auth::id())->attendances()->get();
        if ($attendances->isEmpty()) {
            $attendances = [];
            foreach ($daysOfWeekForMonth as $key => $value) {
                $attendances[] = [
                    'arrival' => null,
                    'leave' => null,
                    'day_of_month' => $value,
                ];
            }
            return $attendances;
        }

        $attendances = [];
        foreach ($daysOfWeekForMonth as $key => $value) {
            $day = $key + 1;
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
        $attendances = [];
        foreach ($request->displayDaysData as $key => $value) {
            $day = $key + 1;
            $attendances[] = Attendance::create([
                'user_id' => Auth::id(),
                'date' =>  "{$dt->year}-{$dt->month}-{$day}",
                'arrival' => $value['arrival'],
                'leave' => $value['leave'],
                'day_of_month' => $value['day_of_month'],
            ]);
        }
    }

    /**
     * 出社時間を更新
     *
     * @param UpdateAttendanceRequest $request
     */
    public function updateArrival(AttendanceUpdateRequest $request, Attendance $attendance)
    {
        $attendance->update([
            'arrival' => $request->attendanceTime['arrival']
        ]);
    }

    /**
     * 退社時間を更新
     *
     * @param UpdateAttendanceRequest $request
     */
    public function updateLeave(AttendanceUpdateRequest $request, Attendance $attendance)
    {
        $attendance->update([
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
        $attendance->update([
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
        $attendance->update([
            'leave' => null
        ]);
    }
}
