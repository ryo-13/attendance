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
     * Display a listing of the resource.
     *
     * @return \Illuminate\Http\Response
     */
    public function index()
    {
        $dt = new Carbon;
        $dayDatas = [];
        for ($i = 1; $i <= $dt->daysInMonth; $i++) {
            $dayDatas[] = [
                'day' => $i,
                'month' => $dt->month,
                'year' => $dt->year,
                'userId' => Auth::id(),
            ];
        }

        $attendances = User::find(Auth::id())->attendances()->get();
        if ($attendances->isEmpty()) {
            $attendances = [];
            foreach ($dayDatas as $dayData) {
                $attendances[] = [
                    'arrival' => null,
                    'leave' => null,
                ];
            }
            return $attendances;
        }

        $attendances = [];
        foreach ($dayDatas as $dayData) {
            $dates = $dayData['year'] . '-' . $dayData['month'] . '-' . $dayData['day'];
            $attendances[] = User::find(Auth::id())->attendances()->where('date', $dates)->latest('created_at')->first();
        }
        return $attendances;
    }

    public function store(StoreAttendanceRequest $request)
    {
        $dt = new Carbon;
        foreach ($request->displayDayDatas as $key => $value) {
            Attendance::create([
                'user_id' => Auth::id(),
                'date' => $dt->year . '-' . $dt->month . '-' . ($key + 1),
                'arrival' => $value['arrival'],
                'leave' => $value['leave']
            ]);
        }
    }

    public function update(UpdateAttendanceRequest $request)
    {
        $dt = new Carbon;
        foreach ($request->displayDayDatas as $key => $value) {
            $dates = $dt->year . '-' . $dt->month . '-' . ($key + 1);
            Attendance::where('user_id', Auth::id())->where('date', $dates)->latest('created_at')->update([
                'date' => $dates,
                'arrival' => $value['arrival'],
                'leave' => $value['leave']
            ]);
        }
    }
}
