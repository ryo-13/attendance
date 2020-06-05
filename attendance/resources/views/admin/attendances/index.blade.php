@extends('layouts.admin.app')

@section('content')

<div class="container mt-5">
    <div class="row">

        @component('components.admin.sidebar')
        @endcomponent

        <div class="col">
            <h1 class="mb-3"> 出退勤照会</h1>
            <span>〇〇年◯月◯日（曜日）</span>
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
                    <tr>
                        <th>1</th>
                        <td>tanaka</td>
                        <td><input type="time"></td>
                        <td><input type="time"></td>
                        <td><input type="time"></td>
                        <td><input type="time"></td>
                        <td><a href=編集画面へ>編集</a></td>
                    </tr>
                </tbody>

            </table>
        </div>

    </div>
</div>

@endsection
