@extends('layouts.app')

@section('links')
<link rel="stylesheet" href="{{URL::asset('assets/css/map.css')}}">
<script src="https://ajax.googleapis.com/ajax/libs/jquery/1.12.0/jquery.min.js"></script>
@endsection

@section('content')
<input id="pac-input" class="controls" type="text" placeholder="Search Box">
<input id="origin-input" class="controls" type="text"
placeholder="Enter an origin location">
<input id="destination-input" class="controls" type="text"
placeholder="Enter a destination location">
<div id="map"></div>
<button onclick="openNav()">Choose Icon</button>
<span style="font-size:30px;cursor:pointer" onclick="openNavr()">&#9776;</span>
<div id="mySidenavr" class="sidenavr">
    <a href="javascript:void(0)" class="closebtnr" onclick="closeNavr()">&#10006;</a>
    <!--Code for chatroom********-->
    <h1>chat</h1>
</div>
<div id="mysidenavl" class="sidenavl">
	
	<ul>
		<li>
			<img src="{{URL::asset('assets/images/markers/up.png')}}" class="icon custom-close" height= 30 width = 30 style="display: block; margin: auto auto;">
			<p style="font-size: 70%; text-align: center;">UP</p>
		</li>
		
		<li>
			<img src="{{URL::asset('assets/images/markers/down.png')}}" class="icon custom-close" height= 30 width = 30 style="display: block; margin: auto auto;">
			<p style="font-size: 70%; text-align: center;">DOWN</p>
		</li>
		
		<li>
			<img src="{{URL::asset('assets/images/markers/slippery.png')}}" class="icon custom-close" height= 30 width = 30 style="display: block; margin: auto auto;">
			<p style="font-size: 70%; text-align: center;">SLIPPERY</p>
		</li>
		
		<li>
			<img src="{{URL::asset('assets/images/markers/help.png')}}" class="icon custom-close" height= 30 width = 30 style="display: block; margin: auto auto;">
			<p style="font-size: 70%; text-align: center;">HELP</p>
		</li>
		
		<li>
			<img src="{{URL::asset('assets/images/markers/rock.png')}}" class="icon custom-close" height= 30 width = 30 style="display: block; margin: auto auto;">
			<p style="font-size: 70%; text-align: center;">ROCK</p>
		</li>
		
		<li>
			<img src="{{URL::asset('assets/images/markers/stair.png')}}" class="icon custom-close" height= 30 width = 30 style="display: block; margin: auto auto;">
			<p style="font-size: 70%; text-align: center;">STAIR</p>
		</li>
		
		<li>
			<img src="{{URL::asset('assets/images/markers/hospital.png')}}" class="icon custom-close" height= 30 width = 30 style="display: block; margin: auto auto;">
			<p style="font-size: 70%; text-align: center;">HOSPITAL</p>
		</li>
		
		<li>
			<img src="{{URL::asset('assets/images/markers/police.png')}}" class="icon custom-close" height= 30 width = 30 style="display: block; margin: auto auto;">
			<p style="font-size: 70%; text-align: center;">POLICE</p>
		</li>
		
		<li>
			<img src="{{URL::asset('assets/images/markers/bus.png')}}" class="icon custom-close" height= 30 width = 30 style="display: block; margin: auto auto;">
			<p style="font-size: 70%; text-align: center;">BUS</p>
		</li>
		
		<li>
			<img src="{{URL::asset('assets/images/markers/construct.png')}}" class="icon custom-close" height= 30 width = 30 style="display: block; margin: auto auto;">
			<p style="font-size: 70%; text-align: center;">CONSTRUCT</p>
		</li>
	</ul>
	<ul>
		<li>
			<img src="{{URL::asset('assets/images/markers/deadend.png')}}" class="icon custom-close" height= 30 width = 30 style="display: block; margin: auto auto;">
			<p style="font-size: 70%; text-align: center;">DEADEND</p>
		</li>
		
		<li>
			<img src="{{URL::asset('assets/images/markers/dog.png')}}" class="icon custom-close" height= 30 width = 30 style="display: block; margin: auto auto;">
			<p style="font-size: 70%; text-align: center;">DOG</p>
		</li>
		
		<li>
			<img src="{{URL::asset('assets/images/markers/drunk.png')}}" class="icon custom-close" height= 30 width = 30 style="display: block; margin: auto auto;">
			<p style="font-size: 70%; text-align: center;">DRUNK</p>
		</li>
		
		<li>
			<img src="{{URL::asset('assets/images/markers/fire.png')}}" class="icon custom-close" height= 30 width = 30 style="display: block; margin: auto auto;">
			<p style="font-size: 70%; text-align: center;">FIRE</p>
		</li>
		
		<li>
			<img src="{{URL::asset('assets/images/markers/narrow.png')}}" class="icon custom-close" height= 30 width = 30 style="display: block; margin: auto auto;">
			<p style="font-size: 70%; text-align: center;">NARROW</p>
		</li>
		
		<li>
			<img src="{{URL::asset('assets/images/markers/elevator.png')}}" class="icon custom-close" height= 30 width = 30 style="display: block; margin: auto auto;">
			<p style="font-size: 70%; text-align: center;">ELEVATOR</p>
		</li>
		
		<li>
			<img src="{{URL::asset('assets/images/markers/shit.png')}}" class="icon custom-close" height= 30 width = 30 style="display: block; margin: auto auto;">
			<p style="font-size: 70%; text-align: center;">POOP</p>
		</li>
		
		<li>
			<img src="{{URL::asset('assets/images/markers/parking.png')}}" class="icon custom-close" height= 30 width = 30 style="display: block; margin: auto auto;">
			<p style="font-size: 70%; text-align: center;">PARKING</p>
		</li>
	</ul>	
</div>
<div id="floating-panel">
		<input type="button" value="Toggle Street View" onclick="toggleStreetView();"></input>
		</div>
		<div id="info"></div>
		<button id="start_button" onclick="startButton(event)">
		<img id="start_img" src="{{URL::asset('assets/images/markers/mic.gif')}}" alt="Start"></button>
		<div id="results">
			<span id="final_span" class="final"></span>
			<span id="interim_span" class="interim"></span>
			<p>
			<div id="div_language">
			<select id="select_language" onchange="updateCountry()"></select>
			&nbsp;&nbsp;
			<select id="select_dialect"></select>
			</div>
		</div>
@endsection

@section('scripts')
<script type="text/javascript" src="{{URL::asset('assets/js/googleMap.js')}}"></script>
<!--Google api-->
<script src="https://maps.googleapis.com/maps/api/js?signed_in=true&amp;&key=AIzaSyD-bMa_k4awmSZ2mW5pqwBvKJEdyevP650&libraries=drawing,places&callback=initMap"async defer></script>
@endsection