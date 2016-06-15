<!DOCTYPE html>
<html lang="en">
<head>
    <meta charset="utf-8">
    <meta http-equiv="X-UA-Compatible" content="IE=edge">
    <meta name="viewport" content="width=device-width, initial-scale=1">

    <title>@yield('title')</title>

    <!-- Fonts -->
    <link rel='stylesheet' type='text/css' href="/fonts/font-awesome.min.css">
    <link rel='stylesheet' type='text/css' href="/fonts/font-googleapis.css">

    <!-- Styles -->
    <link rel="stylesheet" href="/css/bootstrap.min.css">
    <link rel="stylesheet" href="/css/additional.css">
    <link rel="stylesheet" href="/css/selectize.bootstrap3.css">

    {{-- <link href="{{ elixir('css/app.css') }}" rel="stylesheet"> --}}

    <style>
        body {
            font-family: 'Lato';
        }

        .fa-btn {
            margin-right: 6px;
        }
    </style>

    <!-- JavaScripts -->
    <script src="/js/jquery.min.js"></script>
    <script src="/js/standalone/selectize.js"></script>
    <script src="/js/nicEdit.js"></script>
    <script type="text/javascript">bkLib.onDomLoaded(nicEditors.allTextAreas);</script>
    <script>
        $(function () {
            $('[data-toggle="tooltip"]').tooltip()
        });
    </script> 
</head>
<body id="app-layout">            
    @include('layouts.navbar')
    <br></br>
    <br></br>
    @yield('content')

    <!-- JavaScripts -->
    <script src="/js/bootstrap.min.js"></script>
    {{-- <script src="{{ elixir('js/app.js') }}"></script> --}}
</body>
</html>
