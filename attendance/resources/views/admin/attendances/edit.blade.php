@extends('layouts.admin.app')

@section('content')

<div class="container mt-5 mx-auto">
    <div class="row">

        @include('components.admin.sidebar')

        <div class="col">
            <h1>出退勤時間更新</h1>
            <form action="{{ route('admin.attendances.update',$attendance->id) }}" method="POST">
                @csrf

                <div class="form-group">
                    <label for="arrival">出社</label>
                    <input type="time" id="arrival"  name="arrival" value="{{ old('arrival', $attendance->arrival) }}"
                        class="form-control @error ('arrival')is-invalid @enderror" style="width: 145px">
                </div>

                <div class="form-group">
                    <label for="leave">退社</label>
                    <input type="time" id="leave" name="leave" value="{{ old('leave', $attendance->leave) }}"
                        class="form-control @error ('leave')is-invalid @enderror" style="width: 145px">
                </div>

                <div class="form-group">
                    <label for="overtime">残業</label>
                    <input type="time" name="overtime" class="form-control  @error ('overtime')is-invalid @enderror"
                        style="width: 145px">
                </div>

                <a href="{{ route('admin.attendances.index') }}" class="btn btn-primary btn-lg">キャンセル</a>
                <button type="submit" class="btn btn-primary btn-lg">更新</button>
            </form>
        </div>

    </div>
</div>

@endsection
