<!--
    Portland Aid Guide, SF '22
    mapView.blade.php - Contains implementation of the Mapbox.com API for displaying the Portland Aid Guide map & shelter locations.
    See https://mapbox.com for more API details for further improvements & development.
-->

@extends('includes.header')
<script src='https://api.mapbox.com/mapbox-gl-js/v2.10.0/mapbox-gl.js'></script>
<link href='https://api.mapbox.com/mapbox-gl-js/v2.10.0/mapbox-gl.css' rel='stylesheet' />
<script src="https://api.mapbox.com/mapbox-gl-js/plugins/mapbox-gl-directions/v4.1.0/mapbox-gl-directions.js"></script>
<link rel="stylesheet" href="https://api.mapbox.com/mapbox-gl-js/plugins/mapbox-gl-directions/v4.1.0/mapbox-gl-directions.css" type="text/css">
<link rel="stylesheet" href="{{ asset('/css/mapbox.css') }}">

@section('body')
<div id="map"></div>

<script src="{{asset('js/mapbox/display.js')}}"></script>
<script src="https://unpkg.com/@mapbox/mapbox-sdk/umd/mapbox-sdk.min.js"></script>
<script src="https://api.mapbox.com/mapbox-gl-js/plugins/mapbox-gl-geocoder/v5.0.0/mapbox-gl-geocoder.min.js"></script>
<link rel="stylesheet" href="https://api.mapbox.com/mapbox-gl-js/plugins/mapbox-gl-geocoder/v5.0.0/mapbox-gl-geocoder.css" type="text/css">
@include('mapBox.mapViewPageTwo')
@include ('mapBox.mapViewPageThree')


<script>
    // When search box gets a value, set the origin to it
    function setLocationSearch(geocoder) {
        let searchText = document.querySelector('.mapboxgl-ctrl-geocoder--input');
        searchText.placeholder = 'Choose a starting place';
        searchText.ariaLabel = 'Choose a starting place';

        geocoder.on('result', function() {
            directions.setOrigin(searchText.value);
            let markers = document.querySelectorAll('.mapboxgl-marker');
            markers.forEach((marker, index) => {
                if (index != 0) {
                    marker.style.display = 'none';
                }
            });
        });
    }

    // When 'X' button is clicked, clear the origin
    function clearLocation() {
        let clearSearchButton = document.querySelector('.mapboxgl-ctrl-geocoder--button');
        clearSearchButton.addEventListener("click", function() {
            const destination = directions.getDestination().geometry.coordinates;
            directions.removeRoutes();
            directions.setDestination(destination);

            let mapboxLogoCtrl = document.querySelector(".mapboxgl-ctrl-bottom-left").querySelector(".mapboxgl-ctrl");
            mapboxLogoCtrl.style.visibility = 'visible';
            mapboxLogoCtrl.classList.remove('shiftup');
        });
    }

    // Display map if data is loaded
    function isLoaded(container, mapDiv) {
        map.on('sourcedata', (e) => {
            if (e.sourceId === 'directions' && e.isSourceLoaded) {
                container.style.visibility = 'hidden';
                mapDiv.style.visibility = 'visible';
            }
        });
    }


    // Move the location button from the top left to the top right
    function moveLocationButtonTopRight() {
        let locationButton = document.querySelector('.mapboxgl-ctrl-top-left').querySelector('.mapboxgl-ctrl-group');
        if (locationButton) {
            locationButton.remove();
            let topRightCtrl = document.querySelector(".mapboxgl-ctrl-top-right");
            topRightCtrl.appendChild(locationButton);
        }
    }

    // Move the location button from the top right to the top left
    function moveLocationButtonTopLeft() {
        let locationButton = document.querySelector('.mapboxgl-ctrl-top-right').querySelectorAll('.mapboxgl-ctrl-group')[1];
        if (locationButton) {
            locationButton.remove();
            let topLeftCtrl = document.querySelector(".mapboxgl-ctrl-top-left");
            topLeftCtrl.appendChild(locationButton);
        }
    }

    // Convert coordinates to an address/place
    function getLocation(event) {
        return new Promise((resolve, reject) => {
            mapboxClient.geocoding
                .reverseGeocode({
                    query: [event.coords.longitude, event.coords.latitude]
                })
                .send()
                .then((response) => {
                    if (
                        response &&
                        response.body &&
                        response.body.features &&
                        response.body.features.length
                    ) {
                        var feature = response.body.features[0];
                        resolve(feature.place_name);
                    } else {
                        reject(new Error("Failed to locate address"))
                    }
                });
        });
    }



    // Gets shelter data from controller
    function getShelter() {
        const shelterInfo = JSON.parse('{!! json_encode($result) !!}');
        const name = shelterInfo['Shelter Name'];
        // const contact = shelterInfo['Contact Info'];
        const address = shelterInfo['Location'];
        return addMarker(name, address);
    }

    // Places a marker on the map where the shelter is located
    function addMarker(name, address) {
        return new Promise((resolve, reject) => {
            mapboxClient.geocoding
                .forwardGeocode({
                    query: address,
                    autocomplete: false,
                    limit: 1,
                })
                .send()
                .then((response) => {
                    if (
                        !response ||
                        !response.body ||
                        !response.body.features ||
                        !response.body.features.length
                    ) {
                        console.error('Invalid response:');
                        console.error(response);
                        reject(new Error('Failed to locate shetler'));
                    }
                    const feature = response.body.features[0];
                    // Create a marker and add it to the map.
                    new mapboxgl.Marker().setLngLat(feature.center).setPopup(
                        new mapboxgl.Popup({
                            offset: 25
                        })
                        .setHTML(
                            `<h3>${name}</h3>`
                        )
                    ).addTo(map);
                    resolve(feature.center);
                });
        });
    }

    // Only runs "map directions" related functions once origin has been set
    function watchOrigin() {
        directions.on('origin', function() {
            responsiveDirections();
        });
    }
</script>
@endsection