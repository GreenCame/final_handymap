var map;
var panorama;
function initMap() {
	var origin_place_id = null;
	var destination_place_id = null;
	var centerMap = {lat: 65.00814, lng: 25.53012};
	var travel_mode = google.maps.TravelMode.WALKING;
	
	var map = new google.maps.Map(document.getElementById('map'), {
		center:centerMap,
		zoom: 15,
		maxZoom: 16,
		zoomControl: true,
		zoomControlOptions: {
		style: google.maps.ZoomControlStyle.DEFAULT,
        position: google.maps.ControlPosition.BOTTOM_CENTER},
		streetViewControl: true,
		streetViewControlOptions: {
		position: google.maps.ControlPosition.TOP_RIGHT}
		//disableDefaultUI: true
	});
	
	
	var infoWindow = new google.maps.InfoWindow({map: map});
	
	// Try HTML5 geolocation.
	if (navigator.geolocation) {
		navigator.geolocation.getCurrentPosition(function (position) {
			var pos = {
				lat: position.coords.latitude,
				lng: position.coords.longitude
			};
			
			infoWindow.setPosition(pos);
			infoWindow.setContent('Location found.');
			map.setCenter(pos);
			panorama = map.getStreetView();
			panorama.setPosition(pos);
			panorama.setPov(/** @type {google.maps.StreetViewPov} */({
				heading: 165,
			pitch: 0}));
			}, function () {
			handleLocationError(true, infoWindow, map.getCenter());
		});
		} else {
		// Browser doesn't support Geolocation
		handleLocationError(false, infoWindow, map.getCenter());
	}
	function handleLocationError(browserHasGeolocation, infoWindow, pos) {
		infoWindow.setPosition(pos);
		infoWindow.setContent(browserHasGeolocation ?
		'Error: The Geolocation service failed.' :
		'Error: Your browser doesn\'t support geolocation.');
	}
	
	
	// Here comes the direction and find path function
	var directionsService = new google.maps.DirectionsService;
	var directionsDisplay = new google.maps.DirectionsRenderer;
	directionsDisplay.setMap(map);
	
	var origin_input = document.getElementById('origin-input');
	var destination_input = document.getElementById('destination-input');
	
	map.controls[google.maps.ControlPosition.TOP_LEFT].push(origin_input);
	map.controls[google.maps.ControlPosition.TOP_LEFT].push(destination_input);
	
	var origin_autocomplete = new google.maps.places.Autocomplete(origin_input);
	origin_autocomplete.bindTo('bounds', map);
	var destination_autocomplete =
	new google.maps.places.Autocomplete(destination_input);
	destination_autocomplete.bindTo('bounds', map);
	
	
	function expandViewportToFitPlace(map, place) {
		if (place.geometry.viewport) {
			map.fitBounds(place.geometry.viewport);
			} else {
			map.setCenter(place.geometry.location);
			map.setZoom(13);
		}
	}
	
	origin_autocomplete.addListener('place_changed', function () {
		var place = origin_autocomplete.getPlace();
		if (!place.geometry) {
			window.alert("Autocomplete's returned place contains no geometry");
			return;
		}
		expandViewportToFitPlace(map, place);
		
		// If the place has a geometry, store its place ID and route if we have
		// the other place ID
		origin_place_id = place.place_id;
		route(origin_place_id, destination_place_id, travel_mode,
		directionsService, directionsDisplay);
	});
	
	destination_autocomplete.addListener('place_changed', function () {
		var place = destination_autocomplete.getPlace();
		if (!place.geometry) {
			window.alert("Autocomplete's returned place contains no geometry");
			return;
		}
		expandViewportToFitPlace(map, place);
		
		// If the place has a geometry, store its place ID and route if we have
		// the other place ID
		destination_place_id = place.place_id;
		route(origin_place_id, destination_place_id, travel_mode,
		directionsService, directionsDisplay);
	});
	
	function route(origin_place_id, destination_place_id, travel_mode,
	directionsService, directionsDisplay) {
		if (!origin_place_id || !destination_place_id) {
			return;
		}
		directionsService.route({
			origin: {'placeId': origin_place_id},
			destination: {'placeId': destination_place_id},
			travelMode: travel_mode
			}, function (response, status) {
			if (status === google.maps.DirectionsStatus.OK) {
				directionsDisplay.setDirections(response);
				} else {
				window.alert('Directions request failed due to ' + status);
			}
		});
	}
	//End find path
	
    
			/*$.getJSON("/api/points/get", function (data) {
				$(data).find("marker").each(function () {
					var desc_val = $(this).parent().find('[name="description"]').val();
					  
					  var point 	= new google.maps.LatLng(parseFloat($(this).attr('lat')),parseFloat($(this).attr('lng')));
					  console.log(point);
					  create_marker(point, title, desc_val, false, false, image);
				});
			});	
		*/
		
		//Content structure of info Window for the Markers
		//next line is the get position
		google.maps.event.addListener(map, 'rightclick', function(event) {
		var EditForm = '<p><div class="marker-edit">'+
				'<div class="marker-info-win">'+
		'<div class="marker-inner-win"><span class="info-content">'+	
		'<p id ="text" style="text-align:center">Description:</p>' +
		'<input style="width: 150px" type="text" name="description" class="input" value="Write your description">' + 
		'<br>' +'<input type="button" name="SubmitBtn" value="Submit" class="SubmitBtn">'+'<br>';
		var post = event.latLng;
		var lat = post.lat();
		var lng = post.lng();
		
			create_marker(event.latLng, title,EditForm, true, true, image);
		})
		var contentString = $('<div class="marker-info-win">'+
				'<div class="marker-inner-win"><span class="info-content">'+
				'<h2 class="marker-heading" style="text-align: center">'+title+'</h2>'+
				 +'<br>'+
				'</span><button name="remove-marker" class="remove-marker" title="Remove Marker">Remove Marker</button>'+
				'</div></div>');
	function create_marker(MapPos, MapTitle, MapDesc, Ondrag, Removeable, Image_type){
			var marker = new google.maps.Marker({
			position: MapPos, //map Coordinates where user right clicked
			map: map,
			draggable:Ondrag, //set marker draggable
			animation: google.maps.Animation.DROP, //bounce animation
			title:content,
			icon	: image //custom pin icon
			});
			
			var contentString = $('<div class="marker-info-win">'+
				'<div class="marker-inner-win"><span class="info-content">'+
				'<h1 class="marker-heading">'+MapTitle+'</h1>'+
				MapDesc+ 
				'</span><button name="remove-marker" class="remove-marker" title="Remove Marker">Remove Marker</button>'+
				'</div></div>');	
				
		//Create an infoWindow
		var infowindow = new google.maps.InfoWindow();
		
		//set the content of infoWindow
		infowindow.setContent(contentString[0]);
		
		//add click listner to marker which will open infoWindow
		google.maps.event.addListener(marker, 'click', function() {
			infowindow.open(map,marker); // click on marker opens info window
			
		});
		
		
		//###### remove marker #########/
		var removeBtn 	= contentString.find('button.remove-marker')[0];
		google.maps.event.addDomListener(removeBtn, "click", function(event) {
			marker.setMap(null);
		});
		
		var SubmitBtn = contentString.find('input.SubmitBtn')[0];
		
		google.maps.event.addDomListener(SubmitBtn, "click", function(event) {
		var $this = $(this);
		var latitude = $this.data('lat');
		var longitude = $this.data('lng');
		var desc_val = $this.parent().find('[name="description"]').val();
		var tarr = image.split('/') ; //get the name image
		var file = tarr[tarr.length-1];
		var x = contentString.find('input.input').val();
				contentString.find('input.SubmitBtn').remove();
				contentString.find('input.input').remove();
				contentString.find('button.remove-marker').remove();
				contentString.find('#text').append('<br>' + x + '<br>');
				var marker_replaced =x;
		save_marker(marker, longitude, latitude, desc_val, file, marker_replaced);
		infowindow.close();
			
		});
	}
	
	//end create_marker
	
	function save_marker(Marker, longitude, latitude, description, Image_type, Replaced_data){
		
		var position = Marker.getPosition();
		var lng = position.lng();
		var lat = position.lat();
		var myData = {longitude: lng, latitude:lat, description: description, type: Image_type };
		
		$.ajaxSetup({
				headers:
				{ 'X-CSRF-TOKEN': $('meta[name="csrf-token"]').attr('content') }
			});

			$.ajax({
		        url: '/api/points/add',
		        type: 'POST',    
		        data: myData,
					success:function(data){
					Marker.setDraggable(false);
					alert("Successfully saved");
            },
            error:function (xhr, ajaxOptions, thrownError){
                alert(thrownError); //throw any errors
            }
		});
		
	} //end save point
	
	
	//Here is the manager to draw layer and things
	var image = "assets/images/markers/up.png" ; //default image
	var content= "Going uphill";
	var title = "Uphill";
	//##### menu for icon //
  var active1 = false;
  var active2 = false;
  var active3 = false;
  var active4 = false;
  var active5 = false;
  var active6 = false;
  var active7 = false;
  var active8 = false;
  var active9 = false;
  var active10 = false;
  var active11 = false;
  var active12 = false;
  var active13 = false;
  var active14 = false;
  var active15 = false;
  var active16 = false;
  var active17 = false;
  var active18 = false;

    $('.parent').on('click', function() {
    
    if (!active1) $(this).find('.iconChoose1').css({'background-color': ' #d9d9d9', 'transform': 'translate(-25px,85px)'});
    else $(this).find('.iconChoose1').css({'background-color': 'white', 'transform': 'none'}); 
     if (!active2) $(this).find('.iconChoose2').css({'background-color': ' #d9d9d9', 'transform': 'translate(-25px,130px)'});
    else $(this).find('.iconChoose2').css({'background-color': 'white', 'transform': 'none'});
      if (!active3) $(this).find('.iconChoose3').css({'background-color': ' #d9d9d9', 'transform': 'translate(-25px,175px)'});
    else $(this).find('.iconChoose3').css({'background-color': 'white', 'transform': 'none'});
      if (!active4) $(this).find('.iconChoose4').css({'background-color': ' #d9d9d9', 'transform': 'translate(-25px,220px)'});
    else $(this).find('.iconChoose4').css({'background-color': 'white', 'transform': 'none'});
	 if (!active5) $(this).find('.iconChoose5').css({'background-color': ' #d9d9d9', 'transform': 'translate(-25px,265px)'});
    else $(this).find('.iconChoose5').css({'background-color': 'white', 'transform': 'none'});
	 if (!active6) $(this).find('.iconChoose6').css({'background-color': ' #d9d9d9', 'transform': 'translate(-25px,310px)'});
    else $(this).find('.iconChoose6').css({'background-color': 'white', 'transform': 'none'});
	 if (!active7) $(this).find('.iconChoose7').css({'background-color': ' #d9d9d9', 'transform': 'translate(-25px,355px)'});
    else $(this).find('.iconChoose7').css({'background-color': 'white', 'transform': 'none'});
	 if (!active8) $(this).find('.iconChoose8').css({'background-color': ' #d9d9d9', 'transform': 'translate(-25px,400px)'});
    else $(this).find('.iconChoose8').css({'background-color': 'white', 'transform': 'none'});
	 if (!active8) $(this).find('.iconChoose9').css({'background-color': ' #d9d9d9', 'transform': 'translate(-25px,445px)'});
    else $(this).find('.iconChoose9').css({'background-color': 'white', 'transform': 'none'});
	 if (!active8) $(this).find('.iconChoose10').css({'background-color': ' #d9d9d9', 'transform': 'translate(90px,0px)'});
    else $(this).find('.iconChoose10').css({'background-color': 'white', 'transform': 'none'});
	 if (!active8) $(this).find('.iconChoose11').css({'background-color': ' #d9d9d9', 'transform': 'translate(135px,0px)'});
    else $(this).find('.iconChoose11').css({'background-color': 'white', 'transform': 'none'});
	 if (!active8) $(this).find('.iconChoose12').css({'background-color': ' #d9d9d9', 'transform': 'translate(180px,0px)'});
    else $(this).find('.iconChoose12').css({'background-color': 'white', 'transform': 'none'});
	 if (!active8) $(this).find('.iconChoose13').css({'background-color': ' #d9d9d9', 'transform': 'translate(225px,0px)'});
    else $(this).find('.iconChoose13').css({'background-color': 'white', 'transform': 'none'});
	if (!active8) $(this).find('.iconChoose14').css({'background-color': ' #d9d9d9', 'transform': 'translate(270px,0px)'});
    else $(this).find('.iconChoose14').css({'background-color': 'white', 'transform': 'none'});
	if (!active8) $(this).find('.iconChoose15').css({'background-color': ' #d9d9d9', 'transform': 'translate(315px,0px)'});
    else $(this).find('.iconChoose15').css({'background-color': 'white', 'transform': 'none'});
	if (!active8) $(this).find('.iconChoose16').css({'background-color': ' #d9d9d9', 'transform': 'translate(360px,0px)'});
    else $(this).find('.iconChoose16').css({'background-color': 'white', 'transform': 'none'});
	if (!active8) $(this).find('.iconChoose17').css({'background-color': ' #d9d9d9', 'transform': 'translate(405px,0px)'});
    else $(this).find('.iconChoose17').css({'background-color': 'white', 'transform': 'none'});
	if (!active8) $(this).find('.iconChoose18').css({'background-color': ' #d9d9d9', 'transform': 'translate(450px,0px)'});
    else $(this).find('.iconChoose18').css({'background-color': 'white', 'transform': 'none'});
	
    active1 = !active1;
    active2 = !active2;
    active3 = !active3;
    active4 = !active4;
	active5 = !active5;
    active6 = !active6;
    active7 = !active7;
    active8 = !active8;
	active9 = !active9;
	active10 = !active10;
	active11 = !active11;
	active12 = !active12;
	active13 = !active13;
	active14 = !active14;
	active15 = !active15;
	active16 = !active16;
	active17 = !active17;
	active18 = !active18;
      
    });
	
	//####show chat box
	$("#chat").on("click",function(){
		$(".forms").toggle();
		
	});
	
	$(".icon").click(function(){
		var source = $(this).attr('src');
		content = $(this).attr('alt');
		title = $(this).attr('title');
		image = source;
		$(".main").attr('src', source);
		
	});

var image_array = ["assets/images/markers/bus.png","assets/images/markers/construct.png","assets/images/markers/deadend.png","assets/images/markers/dog.png","assets/images/markers/down.png","assets/images/markers/drunk.png",
			"assets/images/markers/elevator.png","assets/images/markers/fire.png","assets/images/markers/help.png","assets/images/markers/hospital.png","assets/images/markers/narrow.png","assets/images/markers/parking.png",
		"assets/images/markers/police.png","assets/images/markers/rock.png","assets/images/markers/shit.png","assets/images/markers/slippery.png","assets/images/markers/stair.png","assets/images/markers/up.png"];
	
	var json = [{"id":48,"title":"Aperiam saepe iusto quaerat et accusantium. Saepe","longitude":"25.130041155","latitude":"65.621770916"},
				{"id":46,"title":"Quis animi deleniti exercitationem exercitationem ","longitude":"25.534386605","latitude":"65.25616832"},
				{"id":48,"title":"Helgelandskysten","longitude":"25.982207233","latitude":"65.092197307"},
				{"id":48,"title":"Cum et nesciunt sit fugiat voluptate quae. Volupta","longitude":"25.168638629","latitude":"65.786251736"},
				{"id":48,"title":"Sunt accusamus rerum maxime quia sed et eos sunt","longitude":"25.826751635","latitude":"65.779081106"},
				{"id":48,"title":"Et consequuntur est animi est enim id. Mollitia qu","longitude":"25.347448941","latitude":"65.548790617"},
				{"id":48,"title":"Illum modi odit a quia et. Sapiente architecto mol","longitude":"25.168638629","latitude":"65.092197307"},
				{"id":48,"title":"Nulla commodi unde at reprehenderit aspernatur qui","longitude":"25.982207233","latitude":"65.786251736"},
				{"id":48,"title":"Distinctio ipsum omnis quasi a ea facere repella","longitude":"25.826751635","latitude":"65.779081106"},
				{"id":48,"title":"Debitis dolores illo ut corporis consequatur volup..","longitude":"25.347448941","latitude":"65.548790617"},
				{"id":48,"title":"Distinctio animi veniam rem odit. Earum libero fac","longitude":"25.746523764","latitude":"65.789658828"},
				{"id":48,"title":"Qui id cum vel dicta sed iure voluptatem deleniti","longitude":"25.534386605","latitude":"65.25616832"},
				{"id":48,"title":"Rerum adipisci ut beatae ut id. Enim impedit conse","longitude":"25.46776445","latitude":"65.939365596"},
				{"id":48,"title":"Hic quia sit aliquam placeat ut qui. Ut sequi nihi.","longitude":"25.31013199","latitude":"65.850412571"},
				{"id":48,"title":"Et velit repellat quos dicta quia dicta. Animi vel.","longitude":"25.751744969","latitude":"65.270542465"}
				
				 
				];
				

	for(var i = 0; i < json.length; i++) {
    
    // Current object
    var obj = json[i];
	var marker = new google.maps.Marker({
      position: new google.maps.LatLng(obj.latitude,obj.longitude),
      map: map,
	  title: obj.title,
	  icon: image_array[i]
    });
	var clicker = addClicker(marker,obj.title);
     // create_marker(json[i].latLng,"test","loz",false,false,image );


}
	function addClicker(marker, content) {
    google.maps.event.addListener(marker, 'click', function() {
      var infowindow = new google.maps.InfoWindow({map: map});
      if (infowindow) {infowindow.close();}
      infowindow = new google.maps.InfoWindow({content: content});
      infowindow.open(map, marker);
      
    });
  }
	// Create the search box and link it to the UI element.
	var input = document.getElementById('pac-input');
	var searchBox = new google.maps.places.SearchBox(input);
	map.controls[google.maps.ControlPosition.TOP_LEFT].push(input);
	
	// Bias the SearchBox results towards current map's viewport.
	map.addListener('bounds_changed', function () {
		searchBox.setBounds(map.getBounds());
	});
	var markers = [];
	// Listen for the event fired when the user selects a prediction and retrieve
	// more details for that place.
	searchBox.addListener('places_changed', function () {
		var places = searchBox.getPlaces();
		
		if (places.length == 0) {
			return;
		}
		
		// Clear out the old markers.
		markers.forEach(function (marker) {
			marker.setMap(null);
		});
		markers = [];
		
		// For each place, get the icon, name and location.
		var bounds = new google.maps.LatLngBounds();
		places.forEach(function (place) {
			var icon = {
				url: place.icon,
				size: new google.maps.Size(71, 71),
				origin: new google.maps.Point(0, 0),
				anchor: new google.maps.Point(17, 34),
				scaledSize: new google.maps.Size(20, 20)
			};
			
			// Create a marker for each place.
			markers.push(new google.maps.Marker({
				map: map,
				icon: icon,
				title: place.name,
				position: place.geometry.location
			}));
			
			if (place.geometry.viewport) {
				// Only geocodes have viewport.
				bounds.union(place.geometry.viewport);
				} else {
				bounds.extend(place.geometry.location);
			}
		});
		map.fitBounds(bounds);
	});
	
	
	function createMarkers(places) {
		var bounds = new google.maps.LatLngBounds();
		var placesList = document.getElementById('places');
		
		for (var i = 0, place; place = places[i]; i++) {
			var image = {
				url: place.icon,
				size: new google.maps.Size(71, 71),
				origin: new google.maps.Point(0, 0),
				anchor: new google.maps.Point(17, 34),
				scaledSize: new google.maps.Size(25, 25)
			};
			
			var marker = new google.maps.Marker({
				map: map,
				icon: image,
				title: place.name,
				position: place.geometry.location
			});
			
			placesList.innerHTML += '<li>' + place.name + '</li>';
			
			bounds.extend(place.geometry.location);
		}
		map.fitBounds(bounds);
	}
	//ended get the service around
}
function toggleStreetView() {
	var toggle = panorama.getVisible();
	if (toggle == false) {
		panorama.setVisible(true);
		
		} else {
		panorama.setVisible(false);
		
	}
}


// Voice regconition

var langs =
[['Afrikaans',       ['af-ZA']],
 ['Bahasa Indonesia',['id-ID']],
 ['Bahasa Melayu',   ['ms-MY']],
 ['Català',          ['ca-ES']],
 ['Čeština',         ['cs-CZ']],
 ['Deutsch',         ['de-DE']],
 ['English',         ['en-AU', 'Australia'],
                     ['en-CA', 'Canada'],
                     ['en-IN', 'India'],
                     ['en-NZ', 'New Zealand'],
                     ['en-ZA', 'South Africa'],
                     ['en-GB', 'United Kingdom'],
                     ['en-US', 'United States']],
 ['Español',         ['es-AR', 'Argentina'],
                     ['es-BO', 'Bolivia'],
                     ['es-CL', 'Chile'],
                     ['es-CO', 'Colombia'],
                     ['es-CR', 'Costa Rica'],
                     ['es-EC', 'Ecuador'],
                     ['es-SV', 'El Salvador'],
                     ['es-ES', 'España'],
                     ['es-US', 'Estados Unidos'],
                     ['es-GT', 'Guatemala'],
                     ['es-HN', 'Honduras'],
                     ['es-MX', 'México'],
                     ['es-NI', 'Nicaragua'],
                     ['es-PA', 'Panamá'],
                     ['es-PY', 'Paraguay'],
                     ['es-PE', 'Perú'],
                     ['es-PR', 'Puerto Rico'],
                     ['es-DO', 'República Dominicana'],
                     ['es-UY', 'Uruguay'],
                     ['es-VE', 'Venezuela']],
 ['Euskara',         ['eu-ES']],
 ['Français',        ['fr-FR']],
 ['Galego',          ['gl-ES']],
 ['Hrvatski',        ['hr_HR']],
 ['IsiZulu',         ['zu-ZA']],
 ['Íslenska',        ['is-IS']],
 ['Italiano',        ['it-IT', 'Italia'],
                     ['it-CH', 'Svizzera']],
 ['Magyar',          ['hu-HU']],
 ['Nederlands',      ['nl-NL']],
 ['Norsk bokmål',    ['nb-NO']],
 ['Polski',          ['pl-PL']],
 ['Português',       ['pt-BR', 'Brasil'],
                     ['pt-PT', 'Portugal']],
 ['Română',          ['ro-RO']],
 ['Slovenčina',      ['sk-SK']],
 ['Suomi',           ['fi-FI']],
 ['Svenska',         ['sv-SE']],
 ['Türkçe',          ['tr-TR']],
 ['български',       ['bg-BG']],
 ['Pусский',         ['ru-RU']],
 ['Српски',          ['sr-RS']],
 ['한국어',            ['ko-KR']],
 ['中文',             ['cmn-Hans-CN', '普通话 (中国大陆)'],
                     ['cmn-Hans-HK', '普通话 (香港)'],
                     ['cmn-Hant-TW', '中文 (台灣)'],
                     ['yue-Hant-HK', '粵語 (香港)']],
 ['日本語',           ['ja-JP']],
 ['Lingua latīna',   ['la']]];



for (var i = 0; i < langs.length; i++) {
  select_language.options[i] = new Option(langs[i][0], i);
}

select_language.selectedIndex = 6;

updateCountry();
select_dialect.selectedIndex = 6;
showInfo('info_start');

function updateCountry() {
  for (var i = select_dialect.options.length - 1; i >= 0; i--) {
    select_dialect.remove(i);
  }
  var list = langs[select_language.selectedIndex];
  for (var i = 1; i < list.length; i++) {
    select_dialect.options.add(new Option(list[i][1], list[i][0]));
  }
  select_dialect.style.visibility = list[1].length == 1 ? 'hidden' : 'visible';
}
var final_transcript = '';
var recognizing = false;
var ignore_onend;
var start_timestamp;
if (!('webkitSpeechRecognition' in window)) {
  upgrade();
} else {
  start_button.style.display = 'inline-block';
  var recognition = new webkitSpeechRecognition();
  recognition.continuous = false;
  recognition.interimResults = true;
  recognition.onstart = function() {
    recognizing = true;
    showInfo('info_speak_now');
    start_img.src = 'http://laravel.dev/assets/images/markers/mic-animate.gif';
  };
  recognition.onerror = function(event) {
    if (event.error == 'no-speech') {
      start_img.src = 'http://laravel.dev/assets/images/markers/mic.gif';
      showInfo('info_no_speech');
      ignore_onend = true;

    }
    if (event.error == 'audio-capture') {
      start_img.src = 'http://laravel.dev/assets/images/markers/mic.gif';
      showInfo('info_no_microphone');
      ignore_onend = true;

    }
    if (event.error == 'not-allowed') {
      if (event.timeStamp - start_timestamp < 100) {
        showInfo('info_blocked');
      } else {
        showInfo('info_denied');

      }
      ignore_onend = true;

    }
  };
  recognition.onend = function() {
    recognizing = false;
    if (ignore_onend) {
      return;

    }
    start_img.src = 'http://laravel.dev/assets/images/markers/mic.gif';
    if (!final_transcript) {
      showInfo('info_start');
      return;

    }
    showInfo('');
    if (window.getSelection) {
      window.getSelection().removeAllRanges();
      var range = document.createRange();
      range.selectNode(document.getElementById('final_span'));
      window.getSelection().addRange(range);

    }
    
  };
  recognition.onresult = function(event) {
    var interim_transcript = '';
    for (var i = event.resultIndex; i < event.results.length; ++i) {
      if (event.results[i].isFinal) {
        final_transcript += event.results[i][0].transcript;
      } else {
        interim_transcript += event.results[i][0].transcript;


      }
    }
    final_transcript = capitalize(final_transcript);
    final_span.innerHTML = linebreak(final_transcript);
    interim_span.innerHTML = linebreak(interim_transcript);
    if (final_transcript || interim_transcript) {
      showButtons('inline-block');

    }
  };

}
function upgrade() {
  start_button.style.visibility = 'hidden';
  showInfo('info_upgrade');

}
var two_line = /\n\n/g;
var one_line = /\n/g;
function linebreak(s) {
  return s.replace(two_line, '<p></p>').replace(one_line, '<br>');

}
var first_char = /\S/;
function capitalize(s) {
  return s.replace(first_char, function(m) { return m.toUpperCase(); });

}
function startButton(event) {
  if (recognizing) {
    recognition.stop();
    return;

  }
  final_transcript = '';
  recognition.lang = select_dialect.value;
  recognition.start();
  ignore_onend = false;
  final_span.innerHTML = '';
  interim_span.innerHTML = '';
  start_img.src ="http://laravel.dev/assets/images/markers/mic-slash.gif";
  showInfo('info_allow');
  showButtons('none');
  start_timestamp = event.timeStamp;

}
function showInfo(s) {
  if (s) {
    for (var child = info.firstChild; child; child = child.nextSibling) {
      if (child.style) {
        child.style.display = child.id == s ? 'inline' : 'none';
      }
    }
    info.style.visibility = 'visible';
  } else {
    info.style.visibility = 'hidden';
  }
}
var current_style;
function showButtons(style) {
  if (style == current_style) {
    return;

  }
  current_style = style;
}
