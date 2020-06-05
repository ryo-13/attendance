@extends('layouts.admin.app')

@section('content')

<div class="container mt-5 mx-auto">
    <div class="row">

        @component('components.admin.sidebar')
        @endcomponent

        <div class="col">
            <h1>出退勤時間更新</h1>
            <form action="" method="POST">
                @csrf

                <div class="form-group">
                    <label for="coming_to_work">出社</label>
                    <input type="time" name="coming_to_work"
                        class="form-control @error ('comming_to_work')is-invalid @enderror" style="width: 145px">
                </div>

                <div class="form-group">
                    <label for="leaving_the_company">退社</label>
                    <input type="time" name="leaving_the_company"
                        class="form-control @error ('leaving_the_company')is-invalid @enderror" style="width: 145px">
                </div>

                <div class="form-group">
                    <label for="overtime">残業</label>
                    <input type="time" name="overtime" class="form-control  @error ('overtime')is-invalid @enderror"
                        style="width: 145px">
                </div>

                <button><a href="出退勤一覧へ">キャンセル</a></button>
                <button type="submit" class="ml-2 bg-info">更新</button>
            </form>
        </div>

    </div>
</div>

@endsection