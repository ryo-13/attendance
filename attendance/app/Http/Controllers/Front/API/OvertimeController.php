<?php

namespace App\Http\Controllers\Front\API;

use App\Http\Controllers\Controller;
use App\Http\Requests\Front\API\OvertimeStoreRequest;
use App\Models\Overtime;
use App\Models\Attendance;
use Illuminate\Http\Request;

class OvertimeController extends Controller
{
    /**
     * attendancesテーブルからdate
     * overtimesテーブルからその他取得
     *
     * @param Request $request
     * @return array $response
     */
    public function getOvertimes(Request $request)
    {
        $attendances = $request->user()->attendances()->with('overtime')->orderBy('date', 'asc')->get();
        $response = [];
        foreach ($attendances as $attendance) {
            if ($attendance->overtime()->doesntExist()) {
                continue;
            }
            $overtime = $attendance->overtime;
            $overtime['date'] = $attendance->date;
            $response[] = $overtime;
        }
        return $response;
    }

    /**
     * 勤怠テーブル勤務日を検索なければ作成
     * 残業レコードで出退勤_IDを検索あれば更新なければ作成
     *
     * @param OvertimeStoreRequest $request
     * @return void
     */
    public function store(OvertimeStoreRequest $request)
    {
        $attendance = Attendance::firstOrCreate(
            ['user_id' => $request->user()->id, 'date' => $request->date],
        );

        $overtime = Overtime::updateOrCreate(
            ['attendance_id' => $attendance->id],
            [
                'overtime' => $request->overtime,
                'overtime_reason' => $request->reason,
                'is_permitted' => false
            ],
        );
    }

    public function destroy(Overtime $overtime)
    {
        $this->authorize('delete', $overtime);

        $overtime->delete();
    }
}
