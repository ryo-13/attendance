@extends('layouts.admin.app')

@section('content')

    <div class="container mt-5">
        <div class="row">

            @include('components.admin.sidebar')

            <div class="col">
                <h1 class="mb-3"> 作業者一覧</h1>
                <button type="submit" class="mb-2 bg-info"><a href="{{ route('admin.users.create') }}">作成</a></button>
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
                    @foreach ($users as $user)
                        <tr>
                            <th>{{ $user->id }}</th>
                            <td>{{ $user->name }}</td>
                            <td>{{ $user->email }}</td>
                            <td><a href="{{ route('admin.users.edit', $user->id) }}">編集</a></td>
                            <form action="{{ route('admin.users.destroy',$user->id) }}" method="POST">
                                @csrf
                                @method('DELETE')

                                <td>
                                    <button type="submit" class="bg-danger">削除</button>
                                </td>
                            </form>
                        </tr>
                    @endforeach
                    </tbody>
                </table>

            </div>

        </div>
    </div>

@endsection
