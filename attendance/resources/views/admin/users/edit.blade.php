@extends('layouts.admin.app')

@section('content')

    <div class="container mt-5 mx-auto">
        <div class="row">

            @include('components.admin.sidebar')

            <div class="col">
                <h1>作業者編集</h1>
                <form action="{{ route('admin.users.update',$user->id )}}" method="POST">
                    @csrf

                    <div class="form-group">
                        <label for="name">作業者</label>
                        <input type="text" id="name" name="name" value="{{ old('name', $user->name)  }}"
                               class="form-control @error ('name')is-invalid @enderror">
                    </div>

                    <div class="form-group">
                        <label for="email">メールアドレス</label>
                        <input type="email" id="email" name="email" value="{{ old('email', $user->email)  }}"
                               class="form-control @error ('email')is-invalid @enderror">
                    </div>

                    <div class="form-group">
                        <label for="password">パスワード</label>
                        <input type="password" id="password" name="password"
                               autocomplete="new-password" value="{{ old('password', $user->password) }}"
                               class="form-control  @error ('password')is-invalid @enderror">
                    </div>

                    <div class="form-group">
                        <label for="password_confirmation">パスワード（確認）</label>
                        <input type="password" id="password_confirmation" name="password_confirmation"
                               autocomplete="new-password" value="{{ old('password', $user->password)  }}"
                               class="form-control  @error ('password_confirmation')is-invalid @enderror">
                    </div>

                    <a href="{{ route('admin.users.index') }}" class="btn btn-primary btn-lg">キャンセル</a>
                    <button type="submit" class="btn btn-primary btn-lg">編集</button>
                </form>
            </div>
        </div>
    </div>

@endsection
