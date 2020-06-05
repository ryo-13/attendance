@extends('layouts.admin.app')

@section('content')

<div class="container mt-5">
    <div class="row">

        @component('components.admin.sidebar')
        @endcomponent

        <div class="col">
            <h1 class="mb-3"> 作業者一覧</h1>
            <button type="submit" class="mb-2 bg-info">作成</button>
            <table class="table table-striped">
                <thead>
                    <tr>
                        <th>ID</th>
                        <th>氏名</th>
                        <th>メールアドレス</th>
                        <th></th>
                        <th></th>
                    </tr>
                </thead>
                <tbody>
                    <tr>
                        <th>1</th>
                        <td>tanaka</td>
                        <td>test@a.com</td>
                        <td><a href=編集画面へ>編集</a></td>
                        <form action="" method="POST">
                            @csrf
                            @method('DELETE')

                            <td> <button type="submit" class="bg-danger">削除</button></td>
                        </form>
                    </tr>
                </tbody>
            </table>

        </div>

    </div>
</div>

@endsection
