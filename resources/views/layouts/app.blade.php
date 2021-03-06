<!DOCTYPE html>
<html lang="en">
<head>
    <meta charset="utf-8">
    <meta http-equiv="X-UA-Compatible" content="IE=edge">
    <meta name="viewport" content="width=device-width, initial-scale=1">
    <meta name="csrf-token" content="{{ csrf_token() }}" />

    <title>HandyMap</title>

    <!-- Fonts -->
    <link href="https://cdnjs.cloudflare.com/ajax/libs/font-awesome/4.4.0/css/font-awesome.min.css" rel='stylesheet'
          type='text/css'>
    <link href="https://fonts.googleapis.com/css?family=Lato:100,300,400,700" rel='stylesheet' type='text/css'>

    <!-- Styles -->
    <link href="https://maxcdn.bootstrapcdn.com/bootstrap/3.3.6/css/bootstrap.min.css" rel="stylesheet">
    {{-- <link href="{{ elixir('css/app.css') }}" rel="stylesheet"> --}}

    <link rel="stylesheet" href="{{URL::asset('assets/css/base.css')}}">
    @yield('links')
</head>
<body id="app-layout">
<nav class="navbar navbar-default navbar-static-top">
    <div class="container">
            <a class="navbar-brand" href="{{ url('/') }}" style="color:black">
                <span class=" glyphicon glyphicon-map-marker" style="color:#EC8A0A"></span> HandyMap
            </a>
			
			<button id="start_button" onclick="startButton(event)">
		    <img id="start_img" src="{{URL::asset('assets/images/markers/mic.gif')}}" alt="Start"></button>
			<select id="select_language" class="controll" onchange="updateCountry()"></select>
			&nbsp;&nbsp;
			<select id="select_dialect" class="controll"></select>	


               <!-- Right Side Of Navbar -->
                <ul class="nav navbar-nav navbar-right">
                    <!-- Authentication Links -->
                    @if (Auth::guest())
                        <li><a href="{{ url('/login') }}">Login</a></li>
                        <li><a href="{{ url('/register') }}">Register</a></li>
                    @else
                        <li class="dropdown" style="color:#EC8A0A">
                            <a href="#" class="dropdown-toggle" data-toggle="dropdown" role="button"
                               aria-expanded="false">
                                <img height="25" class="avatar" style="margin-right: 10px"
                                     src="{{URL::asset('assets/images/avatars/'.Auth::user()->avatar)}}">
                                {{ Auth::user()->pseudo }} <span class="caret"></span>
                            </a>
                            <ul class="dropdown-menu" role="menu">
                                <li><a href="{{ url('/contribution/'.Auth::user()->pseudo) }}"><i class="fa fa-btn fa-flag"></i>
                                        Contribution</a>
                                </li>
                                @if (Auth::user()->isAdmin)
                                    <li><a href="{{ url('/console') }}"><i class="fa fa-btn fa-dashboard"></i>
                                            Console</a>
                                    </li>
                                @endif
                                @if (!Auth::user()->isAdmin)
                                    <li><a href="{{ url('/feedback') }}"><i class="fa fa-btn fa-check"></i>
                                            Feedback</a>
                                    </li>
                                @endif

                                <li><a href="{{ url('/profile') }}"><i class="fa fa-btn fa-cog"></i> Profile</a>
                                </li>
                                <li><a href="{{ url('/logout') }}"><i class="fa fa-btn fa-sign-out"></i> Logout</a>
                                </li>
                            </ul>

                        </li>
                    @endif
                </ul>
        
    </div>
</nav>

@yield('content')

        <!-- JavaScripts -->
@yield('scripts')
<script src="https://cdnjs.cloudflare.com/ajax/libs/jquery/2.1.4/jquery.min.js"></script>
<script src="https://maxcdn.bootstrapcdn.com/bootstrap/3.3.6/js/bootstrap.min.js"></script>
{{-- <script src="{{ elixir('js/app.js') }}"></script> --}}
</body>
</html>
