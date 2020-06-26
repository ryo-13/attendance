<?php

namespace App\Http\Controllers\Admin;

use App\Http\Requests\Admin\AttendanceUpdateRequest;
use App\Models\Attendance;
use App\Http\Controllers\Controller;
use Carbon\Carbon;

class AttendanceController extends Controller
{
    /**
     * @return \Illuminate\Contracts\View\Factory|\Illuminate\View\View
     */
    public function index()
    {
        $attendances = Attendance::query()->get();
        $today = Carbon::today()->toDateString();
        $breaktime = Carbon::createFromTime(01,00,00);

        foreach ($attendances as $attendance) {
            $arrival = new Carbon($attendance->arrival);
            $leave = new Carbon($attendance->leave);
             $attendance['worktime'] = date("H:i:s", strtotime($leave) -
                 strtotime($arrival)-strtotime($breaktime));
        }

        return view('admin.attendances.index',compact(
            'attendances',
            'today'
        ));
    }

    /**
     * @param Attendance $attendance
     * @return \Illuminate\Contracts\View\Factory|\Illuminate\View\View
     */
    public function edit(Attendance $attendance)
    {
        return view('admin.attendances.edit',compact(
            'attendance'
        ));
    }

    /**
     * @param AttendanceUpdateRequest $request
     * @param Attendance $attendance
     * @return \Illuminate\Contracts\View\Factory|\Illuminate\View\View
     */
    public function update(AttendanceUpdateRequest $request, Attendance $attendance)
    {
        $parameters = $request->validated();

        $attendance->update($parameters);

        return redirect(route('admin.attendances.index'));
    }
}
