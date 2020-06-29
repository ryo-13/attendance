@extends('layouts.admin.app')

@section('content')

<div class="container mt-5">
    <div class="row">

        @include('components.admin.sidebar')

        <div class="col">
            <h1 class="mb-3"> 出退勤照会</h1>
            <span>{{ $today }}</span>
            <table class="table table-striped">
                <thead>
                <tr>
                <th>ID</th>
                <th>氏名</th>
                <th>出社</th>
                <th>退社</th>
                <th>残業</th>
                <th>実働</th>
                <th></th>
                </tr>
                </thead>
                <tbody>

                @foreach ($attendances as $attendance)
                    <tr>
                        <th>{{ $attendance->id }}</th>
                        <td>{{ $attendance->user->name }}</td>
                        <td><input type="time" value="{{ $attendance->arrival }}"></td>
                        <td><input type="time" value="{{ $attendance->leave }}"></td>
                        <td><input type="time"></td>
                        <td><input type="time" value="{{ $attendance->worktime }}"></td>
                        <td><a href={{ route('admin.attendances.edit',$attendance->id) }}>編集</a></td>
                    </tr>
                @endforeach

                </tbody>
            </table>
        </div>
    </div>
</div>

@endsection
