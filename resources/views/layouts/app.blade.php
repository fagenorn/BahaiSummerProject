<!DOCTYPE html>
<html>
<head>
    <meta charset="UTF-8">
    <meta name="viewport"
          content="width=device-width, user-scalable=no, initial-scale=1.0, maximum-scale=1.0, minimum-scale=1.0">
    <meta http-equiv="X-UA-Compatible" content="ie=edge">
    <meta name="csrf-token" content="{{ csrf_token() }}">
    <link href="{!! asset('css/app.css') !!}" media="all" rel="stylesheet" type="text/css"/>
    <script type="text/javascript" src="{!! asset('js/app.js') !!}"></script>
    <title>Summer School</title>
</head>
<body>
<div id="app" class="container">
    @yield('content')
</div>
</body>
</html>