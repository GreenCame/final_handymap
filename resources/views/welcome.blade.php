@extends('layouts.welcome')

@section('content')
<div id="slogan">
    <div class="test"></div>
    <div class="test animated bounceInUp "><img src="/assets/images/welcome_Page/navigation.png" /></div>
    <div class="test animated bounceInUp"><img src="/assets/images/welcome_Page/markers.png" /></div>
    <div class="test animated bounceInUp"><img src="/assets/images/welcome_Page/chat.png" /></div>
    <div class="test"></div>
    <h1 class="slogantext animated lightSpeedIn">Optimized for Handicapped people</h1>
</div>
<div style="width: 100%;height: 30px; text-align:center">
    <div style="display: inline-block">
        <a href="/register">
            <button id="show" style="display: block; margin:50px auto; " class="animated fadeInUp buttonSignUp"> <span class=" glyphicon glyphicon-map-marker"></span> Sign Up</button>
        </a>
    </div>
    <div style="display: inline-block">
        <a href="/login">
            <button id="show" style="display: block; margin:50px auto; " class="animated fadeInUp buttonLogin"><span class=" glyphicon glyphicon-chevron-right"></span> Login</button>
        </a>
    </div>
</div>
@endsection