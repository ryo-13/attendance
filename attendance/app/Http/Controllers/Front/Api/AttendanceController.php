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

        $results = [];
        if ($attendances->isEmpty()) {
            foreach ($currentMonthPeriod as $currentMonthDay) {
                $results[] = [
                    'arrival' => null,
                    'leave' => null,
                    'day_of_week' => $currentMonthDay->isoFormat('ddd'),
                ];
            }
            return $results;
        }

        foreach ($currentMonthPeriod as $currentMonthDay) {
            $results[] = Auth::user()->attendances()->where('date', $currentMonthDay)->first();
        }
        return $results;
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
        return response()->json($attendances);
    }

    /**
     * 出社時間を更新
     *
     * @param UpdateAttendanceRequest $request
     */
    public function updateArrival(AttendanceArrivalUpdateRequest $request, Attendance $attendance)
    {
        $response = $attendance->update([
            'arrival' => $request->attendanceTime['arrival']
        ]);
        return response()->success($response);
    }

    /**
     * 退社時間を更新
     *
     * @param UpdateAttendanceRequest $request
     */
    public function updateLeave(AttendanceLeaveUpdateRequest $request, Attendance $attendance)
    {
        $response = $attendance->update([
            'leave' => $request->attendanceTime['leave']
        ]);
        return response()->json($response);
    }

    /**
     * 出社時間をリセット
     *
     * @param Attendance $attendance
     * @return void
     */
    public function resetArrival(Attendance $attendance)
    {
        $response = $attendance->update([
            'arrival' => null
        ]);
        return response()->json($response);
    }

    /**
     * 退社時間をリセット
     *
     * @param Attendance $attendance
     * @return void
     */
    public function resetLeave(Attendance $attendance)
    {
        $response = $attendance->update([
            'leave' => null
        ]);
        return response()->json($response);
    }
}
