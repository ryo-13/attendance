@extends('layouts.admin.app')

@section('content')

<div class="container mt-5 mx-auto">
    <div class="row">

        @component('components.admin.sidebar')
        @endcomponent

        <div class="col">
            <h1>残業申請</h1>

            <table class="table">
                <tbody>
                    <tr>
                        <th>氏名</th>
                        <td>tanaka</td>
                    </tr>
                    <tr>
                        <th>勤務日</th>
                        <td>◯月◯日</td>
                    </tr>
                    <tr>
                        <th>残業時間</th>
                        <td>10:10</td>
                    </tr>
                    <tr>
                        <th>申請理由</th>
                        <td>リリース前のため</td>
                    </tr>
                </tbody>
            </table>

            <form action="" method="POST" style="display: inline-block">
                @csrf
                @method('DELETE')
                <button type="submit" class="ml-2 bg-danger">拒否</button>
            </form>

            <form action="" method="POST" style="display: inline-block">
                @csrf
                <button type="submit" class="ml-2 bg-info d-inline">承認</button>
            </form>

        </div>

    </div>
</div>

@endsection
