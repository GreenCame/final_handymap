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
    <!-- Styles -->
    <link href="https://maxcdn.bootstrapcdn.com/bootstrap/3.3.6/css/bootstrap.min.css" rel="stylesheet">
</head>

<body style="background:url('assets/images/welcome_Page/bg.jpg') fixed center no-repeat; ">

<div class="pen-title">


    <img class="animated bounceInDown infinte pulse" src="/assets/images/welcome_Page/map.png" />
    <h1 class="animated zoomIn">HandyMap</h1>
</div>

@yield("content")



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
