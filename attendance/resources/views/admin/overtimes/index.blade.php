@extends('layouts.admin.app')

@section('content')

<div class="container mt-5">
    <div class="row">

        @component('components.admin.sidebar')
        @endcomponent

        <div class="col">
            <h1 class="mb-3"> 残業申請一覧</h1>
            <span>〇〇年◯月◯日（曜日）</span>
            <table class="table table-striped">

                <thead>
                    <tr>
                        <th>ID</th>
                        <th>氏名</th>
                        <th>勤務日</th>
                        <th>残業時間</th>
                        <th>申請理由</th>
                        <th></th>
                    </tr>
                </thead>

                <tbody>
                    <tr>
                        <th>1</th>
                        <td>tanaka</td>
                        <td>◯月◯日</td>
                        <td>11:11</td>
                        <td>リリース前のため</td>
                        <td><a href=詳細画面へ>詳細</a></td>
                    </tr>
                </tbody>

            </table>
        </div>

    </div>
</div>

@endsection
