<!DOCTYPE html>
<html lang="{{ config('app.locale') }}">

<head>
    <meta charset="utf-8">
    <meta http-equiv="X-UA-Compatible" content="IE=edge">
    <meta name="viewport" content="width=device-width, initial-scale=1">
    <link rel="stylesheet" href="//maxcdn.bootstrapcdn.com/bootstrap/3.2.0/css/bootstrap.min.css">

    <!-- CSRF Token -->
    <meta name="csrf-token" content="{{ csrf_token() }}">

    <title>勤怠管理システム</title>

    <script>
        window.Laravel = {!!
        json_encode([
        'apiToken' => \Auth::user()->api_token ?? null
        ])
        !!}
    </script>
</head>

<body>
    <div id="app">
        <navbar></navbar>
        <div class="container">
            <router-view></router-view>
        </div>
    </div>
</body>
<script src="{{ mix('js/app.js') }}"></script>

</html>
