<?php

namespace App\Http\Controllers\Admin;

use App\Http\Requests\Admin\AttendanceUpdateRequest;
use App\Models\Attendance;
use App\Http\Controllers\Controller;

class AttendanceController extends Controller
{
    /**
     * @return \Illuminate\Contracts\View\Factory|\Illuminate\View\View
     */
    public function index()
    {
        $attendances = Attendance::query()->get();
        $getdate = date("Y-m-d");

        foreach ($attendances as $attendance) {
             $attendance['worktime'] = date("H:i:s", strtotime($attendance->leave) -
                 strtotime($attendance->arrival)-strtotime("01:00:00"));
        }

        return view('admin.attendances.index',compact(
            'attendances',
            'getdate'
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
