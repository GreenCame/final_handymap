@extends('layouts.app')

@section('links')
<link rel="stylesheet" href="{{URL::asset('assets/css/map.css')}}">
<script src="https://ajax.googleapis.com/ajax/libs/jquery/1.12.0/jquery.min.js"></script>
@endsection


@section('content')

		
		
			
			
			
<!-- Area of Search box -->		
<input id="pac-input" class="controls" type="text" placeholder="Search Box">
<input id="origin-input" class="controls" type="text"
placeholder="Enter an origin location">
<input id="destination-input" class="controls" type="text"
placeholder="Enter a destination location" >


  <div class="parent">
			<div class=" iconChoose iconChoose1">
			<img src="{{URL::asset('assets/images/markers/up.png')}}" class="icon" title="Going Uphill" height= 40 width = 40 style="display: block; margin: auto auto;">
			</div>
			<div class=" iconChoose iconChoose2">
			<img src="{{URL::asset('assets/images/markers/down.png')}}" class="icon" title="Going Downhill" height= 40 width = 40 style="display: block; margin: auto auto;">
			</div>
			<div class=" iconChoose iconChoose3">
			<img src="{{URL::asset('assets/images/markers/slippery.png')}}" class="icon" title="Slippery Road" height= 40 width = 40 style="display: block; margin: auto auto;">
			</div>
			<div class=" iconChoose iconChoose4">
			<img src="{{URL::asset('assets/images/markers/help.png')}}" class="icon" title="SOS! Need Help" height= 40 width = 40 style="display: block; margin: auto auto;">
			</div>
			<div class=" iconChoose iconChoose5">	
			<img src="{{URL::asset('assets/images/markers/rock.png')}}" class="icon" title="Rocky" height= 40 width = 40 style="display: block; margin: auto auto;">
			</div>
			<div class=" iconChoose iconChoose6">
	        <img src="{{URL::asset('assets/images/markers/stair.png')}}" class="icon" title="Stair Ahead" height= 40 width = 40 style="display: block; margin: auto auto;">
			</div>
			<div class=" iconChoose iconChoose7">
		    <img src="{{URL::asset('assets/images/markers/hospital.png')}}" class="icon" title="Hospital" height= 40 width = 40 style="display: block; margin: auto auto;">
			</div>
			<div class=" iconChoose iconChoose8">
		    <img src="{{URL::asset('assets/images/markers/police.png')}}" class="icon" title="Police" height= 40 width = 40 style="display: block; margin: auto auto;">
			</div>
			<div class=" iconChoose iconChoose9">
			<img src="{{URL::asset('assets/images/markers/bus.png')}}" class="icon" title="Bus" height= 40 width = 40 style="display: block; margin: auto auto;">
			</div>
			<div class=" iconChoose iconChoose10">
		    <img src="{{URL::asset('assets/images/markers/construct.png')}}" class="icon" title="Construction" height= 40 width = 40 style="display: block; margin: auto auto;">
			</div>
			<div class=" iconChoose iconChoose11">
			<img src="{{URL::asset('assets/images/markers/deadend.png')}}" class="icon" title="Dead End" height= 40 width = 40 style="display: block; margin: auto auto;">
			</div>
			<div class=" iconChoose iconChoose12">
			<img src="{{URL::asset('assets/images/markers/dog.png')}}" class="icon" title="Crazy Dog" height= 40 width = 40 style="display: block; margin: auto auto;">
			</div>
			<div class=" iconChoose iconChoose13">
			<img src="{{URL::asset('assets/images/markers/drunk.png')}}" class="icon" title="Drunkard" height= 40 width = 40 style="display: block; margin: auto auto;">
			</div>
			<div class=" iconChoose iconChoose14">
			<img src="{{URL::asset('assets/images/markers/fire.png')}}" class="icon" title="Fire" height= 40 width = 40 style="display: block; margin: auto auto;">
			</div>
			<div class=" iconChoose iconChoose15">
			<img src="{{URL::asset('assets/images/markers/narrow.png')}}" class="icon" title="Narrow Road" height= 40 width = 40 style="display: block; margin: auto auto;">
			</div>
			<div class=" iconChoose iconChoose16">
			<img src="{{URL::asset('assets/images/markers/elevator.png')}}" class="icon" title="Elevator" height= 40 width = 40 style="display: block; margin: auto auto;">
			</div>
			<div class=" iconChoose iconChoose17">
			<img src="{{URL::asset('assets/images/markers/shit.png')}}" class="icon custom-close" title="Poop" height= 40 width = 40 style="display: block; margin: auto auto;">
			</div>
			<div class=" iconChoose iconChoose18">
			<img src="{{URL::asset('assets/images/markers/parking.png')}}" class="icon custom-close" title="Parking" height= 40 width = 40 style="display: block; margin: auto auto;">
			</div>
			<div class="mask"><img class="main" style="margin-top: 25px" src="{{URL::asset('assets/images/markers/map.png')}}" alt="" /></div>
</div>
<div class="chat-box">
    <input type="checkbox" / id="chat">
    <label data-expanded="&#10006;" data-collapsed="Click to chat!">
    </label>
    <div class="chat-box-contents">
					<ul class="media-list" id="contentList"  data-user="{{ Auth::user()->id }}">
         @if (count($chats) > 0)
            @foreach ($chats as $chat)
               {!!$chat!!}
            @endforeach
        @endif
</ul>
                
</div>
<div class="forms">
                    <form role="form">
                        <div class="">
                            <textarea id="content" type="text" class="" placeholder="Enter Message" ></textarea>
                        </div>
                        <div class="">
                            <button id="sendBtn" class="pull-rights" type="button">SEND</button>

                        </div>
                    </form>
				</div>
    </div>

    </div>

<div id="map"></div>


@endsection

@section('scripts')
  <script src="https://js.pusher.com/3.0/pusher.min.js"></script>

    <script>
        var pusher = new Pusher("{{ env('PUSHER_KEY') }}",{
          cluster: 'eu'
        });
    </script>    
    <script src="https://ajax.googleapis.com/ajax/libs/jquery/1.12.0/jquery.min.js"></script>
    <script type="text/javascript" src="{{URL::asset('assets/js/chatroom.js')}}"></script>
<script type="text/javascript" src="{{URL::asset('assets/js/googleMap.js')}}"></script>
<!--Google api-->
<script src="https://maps.googleapis.com/maps/api/js?signed_in=true&amp;&key=AIzaSyD-bMa_k4awmSZ2mW5pqwBvKJEdyevP650&libraries=drawing,places&callback=initMap"async defer></script>
@endsection