<html>
    <head>
        <title>Matrix</title>
        <head>
            <link rel="stylesheet" href="https://stackpath.bootstrapcdn.com/bootstrap/4.5.1/css/bootstrap.min.css" integrity="sha384-VCmXjywReHh4PwowAiWNagnWcLhlEJLA5buUprzK8rxFgeH0kww/aWY76TfkUoSX" crossorigin="anonymous">

            <meta charset="utf-8">
            <meta http-equiv="X-UA-Compatible" content="IE=edge">
            <meta name="viewport" content="width=device-width, user-scalable=no, initial-scale=1, maximum-scale=1">
    
            <title>StarMetrics Admin</title>
    
            <meta name="csrf-token" content="{{ csrf_token() }}">
    
            <!-- Font Awesome -->
            <link rel="stylesheet" type="text/css" href="https://maxcdn.bootstrapcdn.com/font-awesome/4.7.0/css/font-awesome.min.css">
        
            @stack('scripts')
        </head>
    </head>
    <body>
        <div class="container" id="app">
            @yield('content')
        </div>
        <script src="{{ url('js/app.js') }}"></script>
    </body>


</html>