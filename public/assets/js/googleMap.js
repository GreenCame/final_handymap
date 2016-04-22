var map;
var panorama;
function initMap() {
	var origin_place_id = null;
	var destination_place_id = null;
	var centerMap = {lat: 65.00814, lng: 25.53012};
	var travel_mode = google.maps.TravelMode.WALKING;
	var map = new google.maps.Map(document.getElementById('map'), {
		center:centerMap,
		zoom: 12,
		streetViewControl: true
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
				heading: 265,
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
	
	//Here is the manager to draw layer and things
	var image = "uphill.png" ; //default image
	var content= "Going uphill";
	var title = "Uphill";
	
	$(".icon").click(function(){
		var source = $(this).attr('src');
		content = $(this).attr('alt');
		title = $(this).attr('title');
		image = source;
		closeNav();
	});
	
	//##### drop a new marker on right click ######
	google.maps.event.addListener(map, 'rightclick', function(event) {
		var marker = new google.maps.Marker({
			position: event.latLng, //map Coordinates where user right clicked
			map: map,
			draggable:true, //set marker draggable
			animation: google.maps.Animation.DROP, //bounce animation
			title:content,
			icon: image //custom pin icon
		});
		
		//Content structure of info Window for the Markers
		//next line is the get position
		var post = event.latLng;
		
		
		var contentString = $('<div class="marker-info-win">'+
		'<div class="marker-inner-win"><span class="info-content">'+
		'<div style="text-align: center;">' + title + '</div>' +
		'<br>' + post +
		'<p id ="text" style="text-align:center">Description:</p>' +
		'<input style="width: 150px" type="text" name="descirption" class="input" value="Write your description">' + 
		'<br>' +
		'<input type="button" name="submit" value="Submit" class="submit">' + '<br>' +
		'<br /><button style="width: 100% ;margin-left:auto; margin-right:auto;" name="remove-marker" class="remove-marker" title="Remove Marker">Remove Marker</button></div></div>');
		//Save value of input text and show on infoWindow, also delete both input field and submit button
		var Submit 	= contentString.find('input.submit')[0];
		google.maps.event.addDomListener(Submit, "click", function(event) {
			
			contentString.find('br').remove();
			var x = contentString.find('input.input').val();
			contentString.find('input.submit').remove();
			contentString.find('input.input').remove();
			contentString.find('#text').append('<br>' + x + '<br>' + "Written by: " + "Getuserhere");
		});
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
		
	});
	
	
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
//Open left nav//
function openNav() {
	document.getElementById("mysidenavl").style.width = "300px";
}

/* Set the width of the side navigation to 0 */
function closeNav() {
	document.getElementById("mysidenavl").style.width = "0";
}
//Open Right nav//
function openNavr() {
	document.getElementById("mySidenavr").style.width = "250px";
}

function closeNavr() {
	document.getElementById("mySidenavr").style.width = "0";
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