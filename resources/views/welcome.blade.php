<!DOCTYPE html>
<html >
<head>
    <meta charset="UTF-8">
    <title>Main Page</title>

    <link rel="stylesheet" href="css/reset.css">
    <link rel="stylesheet" href="{{URL::asset('assets/css/welcome.css')}}">

    <link rel='stylesheet prefetch' href='http://fonts.googleapis.com/css?family=Roboto:400,100,300,500,700,900|RobotoDraft:400,100,300,500,700,900'>
    <link rel='stylesheet prefetch' href='http://maxcdn.bootstrapcdn.com/font-awesome/4.3.0/css/font-awesome.min.css'>
    <link href='https://fonts.googleapis.com/css?family=Lobster' rel='stylesheet' type='text/css'>
</head>

<body style="background:url('assets/images/welcome_Page/bg.jpg') fixed center no-repeat; ">

<div class="pen-title">


    <img class="animated bounceInDown infinte pulse" src="/assets/images/welcome_Page/map.png" />
    <h1 class="animated zoomIn">HandyMap</h1>
</div>
<div id="slogan">
    <div class="test"></div>
    <div class="test animated bounceInUp "><img src="/assets/images/welcome_Page/navigation.png" /></div>
    <div class="test animated bounceInUp"><img src="/assets/images/welcome_Page/markers.png" /></div>
    <div class="test animated bounceInUp"><img src="/assets/images/welcome_Page/chat.png" /></div>
    <div class="test"></div>
    <h1 class="slogantext animated lightSpeedIn">Optimized for Handicapped people</h1>
</div>
<button id="show" style="display: block; margin:50px auto; " onclick="show()" class="animated bounceInDown">Continue</button>


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
</div>
<button id="hide" style="display: none; margin:10px auto;" onclick="hide()" class="animated bounceInUp">Back</button>

<script src='http://cdnjs.cloudflare.com/ajax/libs/jquery/2.1.3/jquery.min.js'></script>


<script src="assets/js/welcomePage.js"></script>
<script>
    function show(){

        document.getElementById("show").style.display = "none";
        document.getElementById("slogan").style.display = "none";
        document.getElementById("form").style.display = "block";
        document.getElementById("hide").style.display = "table";
    }
    function hide(){
        document.getElementById("show").style.display = "table";
        document.getElementById("slogan").style.display = "block";
        document.getElementById("form").style.display = "none";
        document.getElementById("hide").style.display = "none";
    }

</script>
</body>
</html>
