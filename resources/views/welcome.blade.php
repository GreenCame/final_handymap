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


<!-- Form Module-->
<div id ="form" class="module form-module animated lightSpeedIn">
    <div class="toggle">
        <p>Don't have an account? Click here<p>

    </div>
    <div class="form">
        <h2>Login to your account</h2>
        <form>
            <input type="text" placeholder="Username"/>
            <input type="password" placeholder="Password"/>
        </form>
	  <span>
	  <input type="checkbox" name="remember" value="remember" style="float:left;width:initial"/></span>
        <p style="margin-left:20px">Remember me </p>

        <button style="margin-top:10px">Login</button>
        <div class="extra">
            <div class="low">Forgot your password?</div>

        </div>
    </div>
    <div class="form">
        <h2>Create an account</h2>
        <form>
            <input type="text" placeholder="Username"/>
            <input type="password" placeholder="Password"/>
            <input type="password" placeholder="Re-type Password"/>
            <input type="email" placeholder="Email Address"/>
            <button>Register</button>
        </form>
    </div>


</div>
@endsection