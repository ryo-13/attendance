@extends('layouts.admin.app')

@section('content')

<div class="container mt-5 mx-auto">
    <div class="row">

        @component('components.admin.sidebar')
        @endcomponent

        <div class="col">
            <h1>作業者編集</h1>
            <form action="" method="POST">

                <div class="form-group">
                    <label for="name">作業者</label>
                    <input type="text" id="name" name="name" class="form-control @error ('user')is-invalid @enderror">
                </div>

                <div class="form-group">
                    <label for="email">メールアドレス</label>
                    <input type="email" id="email" name="email"
                        class="form-control @error ('email')is-invalid @enderror">
                </div>

                <div class="form-group">
                    <label for="password">パスワード</label>
                    <input type="password" id="password" name="password"
                        class="form-control  @error ('password')is-invalid @enderror">
                </div>

                <div class="form-group">
                    <label for="password_confirmation">パスワード（確認）</label>
                    <input type="password" id="password_confirmation" class="form-control" name="password_confirmation">
                </div>

                <button><a href="出退勤一覧">キャンセル</a></button>
                <button type="submit" class="ml-2 bg-info">編集</button>
            </form>
        </div>
    </div>
</div>

@endsection