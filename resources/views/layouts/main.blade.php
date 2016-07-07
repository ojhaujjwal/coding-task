<!DOCTYPE html>
<html lang="en">
<head>
    <meta charset="utf-8">
    <meta http-equiv="X-UA-Compatible" content="IE=edge">
    <meta name="viewport" content="width=device-width, initial-scale=1">

    <title>{{trans('main.title')}}</title>

    <!-- Fonts -->
    <link href="https://cdnjs.cloudflare.com/ajax/libs/font-awesome/4.4.0/css/font-awesome.min.css" rel='stylesheet' type='text/css'>
    <link href="https://fonts.googleapis.com/css?family=Lato:100,300,400,700" rel='stylesheet' type='text/css'>

    <!-- Styles -->
    <link href="https://maxcdn.bootstrapcdn.com/bootstrap/3.3.6/css/bootstrap.min.css" rel="stylesheet">

    <style>
        body {
            font-family: 'Lato';
        }
        .fa-btn {
            margin-right: 6px;
        }
    </style>

    @yield('head')
</head>
<body id="app-layout">
    <nav class="navbar navbar-default">
        <div class="container">
            <div class="navbar-header">

                <!-- Branding Image -->
                <a class="navbar-brand" href="{{ url('/') }}">
                    {{trans('main.menu.home')}}
                </a>
            </div>
            <div class="collapse navbar-collapse" id="bs-example-navbar-collapse-1">
                <ul class="nav navbar-nav">
                    <li class="dropdown">
                        <a href="#" class="dropdown-toggle" data-toggle="dropdown" role="button" aria-haspopup="true" aria-expanded="false">
                            {{trans('main.menu.personal_details.title')}}
                            <span class="caret"></span>
                        </a>
                      <ul class="dropdown-menu">                      
                            <li>
                                <a href="{{route('personal-details.list')}}">
                                    {{trans('main.menu.personal_details.records')}}
                                </a>
                            </li>
                            <li>
                                <a href="{{route('personal-details.create')}}">
                                    {{trans('main.menu.personal_details.create')}}
                                </a>
                            </li>
                      </ul>
                    </li>                    
                </ul>
            </div>
        </div>
    </nav>

    <div id="page-wrapper">
        @yield('content')
    </div>

            <!-- JavaScripts -->
    <script src="https://cdnjs.cloudflare.com/ajax/libs/jquery/2.2.4/jquery.min.js"></script>
    <script src="https://maxcdn.bootstrapcdn.com/bootstrap/3.3.6/js/bootstrap.min.js"></script>
    @yield('scripts')
    {{-- <script src="{{ elixir('js/app.js') }}"></script> --}}
</body>
</html>
