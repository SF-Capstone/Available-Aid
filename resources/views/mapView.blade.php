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
<script>
    const mapboxClient = mapboxSdk({
        accessToken: mapboxgl.accessToken
    });

    $(document).ready(() => {
        addGeocoder();
        addLoader();
        defaultWalking();
        shiftLocationButton();
        setLocationButton();
        setShelter();
        watchOrigin();
    });

    // Add a geocoder control to the map
    // to function as the search box
    function addGeocoder() {
        let geocoder = new MapboxGeocoder({
            accessToken: mapboxgl.accessToken,
            countries: 'us',
            bbox: [-124.566244, 41.991794, -116.463504, 46.292035],
            filter: function(item) {
                return item.context.some((i) => {
                    return (
                        i.id.split('.').shift() === 'region' &&
                        i.text === 'Oregon'
                    );
                });
            },
            mapboxgl: mapboxgl
        });
        map.addControl(geocoder, 'top-left');

        setLocationSearch(geocoder);
        clearLocation();
    }

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

    // Add a loading spinner
    function addLoader() {
        let container = document.createElement('div')
        container.id = 'loadContainer';
        container.className = 'loaderContainer';
        let loader = document.createElement('img');
        loader.id = 'loading';
        loader.className = 'loader'
        container.appendChild(loader)

        let mapDiv = document.getElementById('map');
        mapDiv.appendChild(container);

        container.style.maxHeight = container.style.height = mapDiv.offsetHeight;
        container.style.maxWidth = container.style.width = mapDiv.offsetWidth;
        mapDiv.style.visibility = 'hidden';
        container.style.visibility = 'visible';
        isLoaded(container, mapDiv);
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

    // Make the map default to the walking profile
    function defaultWalking() {
        let walking = document.getElementById('mapbox-directions-profile-walking');
        walking.click();
    }

    // Move location button to the top left/top right control 
    // depending on window size
    function shiftLocationButton() {
        const resizeObserver = new ResizeObserver((entries) => {
            if ($(window).width() <= 400) {
                moveLocationButtonTopRight();
            } else {
                moveLocationButtonTopLeft();
            }
        });
        let mapDiv = document.getElementById('map');
        resizeObserver.observe(mapDiv);
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

    // When location button is clicked 
    // sets the user's origin to their geolocated position
    function setLocationButton() {
        geolocate.on('geolocate', function(event) {
            getLocation(event)
                .then(location => {
                    // Update search box
                    let searchText = document.querySelector('.mapboxgl-ctrl-geocoder--input');
                    searchText.value = location;

                    // Show clear 'X' button
                    let clearSearchButton = document.querySelector('.mapboxgl-ctrl-geocoder--button');
                    clearSearchButton.style.display = 'block';

                    directions.setOrigin(location);
                })
                .catch(error => {
                    console.error(error);
                });
        });
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
    // Sets the destination to the desired shelter
    function setShelter() {
        getShelter()
            .then(destination => {
                const destLong = destination[0];
                const destLat = destination[1];
                directions.setDestination([destLong, destLat]);
            })
            .catch(error => {
                console.error(error);
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

    // Calls functions that make the map directions responsive
    function responsiveDirections() {
        let directionWindow = document.querySelector(".directions-control-directions");
        // let popupCtrl =document.querySelector(".mapboxgl-popup");

        // If map directions are currently being displayed
        if (directionWindow) {
            moveDirectionWindow();

            directionWindow.classList.add('collapsed');
            directionWindow.classList.toggle('collapsed');

            let mapboxLogoCtrl = document.querySelector(".mapboxgl-ctrl-bottom-left").querySelector(".mapboxgl-ctrl");
            mapboxLogoCtrl.classList.add('shiftup');

            addDirectionToggle(directionWindow);
            styleCollapsed();
            resizeDirections(directionWindow, mapboxLogoCtrl);
            $(window).trigger('resize');
        }
    }

    // Separate direction inputs and direction instructions 
    // from each other for easier CSS formatting
    function moveDirectionWindow() {
        let instructions = document.querySelector(".directions-control-instructions");
        instructions.remove();
        let botLeftCtrl = document.querySelector(".mapboxgl-ctrl-bottom-left");
        botLeftCtrl.appendChild(instructions);
    }

    // Adds a button that collapses directions when clicked
    function addDirectionToggle(directionWindow) {
        let directionToggle = document.createElement('button');
        directionToggle.id = 'directionToggle';
        directionToggle.className = 'dirToggle btn btn-sm btn-secondary';
        directionToggle.textContent = 'Hide';

        const directionToggleExists = document.getElementById("directionToggle");
        if (!directionToggleExists) {
            directionWindow.appendChild(directionToggle);
        }

        toggleDirections(directionToggle);
    }

    // Show or collapse directions when clicked
    function toggleDirections(directionToggle) {
        directionToggle.addEventListener('click', function() {
            let directionWindow = document.querySelector(".directions-control-directions");
            directionWindow.classList.toggle('collapsed');
            styleCollapsed();
        })
    }

    // Check if direction window is collapsed 
    // and style map elements accordingly
    function styleCollapsed() {
        let directionToggle = document.querySelector('.dirToggle');
        let directionWindow = document.querySelector(".directions-control-directions");
        let popupCtrl = document.querySelector(".mapboxgl-popup");
        let mapboxLogoCtrl = document.querySelector(".mapboxgl-ctrl-bottom-left").querySelector(".mapboxgl-ctrl");

        if (directionWindow) {
            if (directionWindow.classList.contains('collapsed')) {
                if (popupCtrl) popupCtrl.style.setProperty("visibility", "visible", "important");
                directionToggle.textContent = 'Show directions';
                directionWindow.addEventListener("transitionend", function visible() {
                    directionWindow.removeEventListener("transitionend", visible);
                    mapboxLogoCtrl.style.visibility = "visible";
                });
            } else {
                directionToggle.textContent = 'Hide';
                mapboxLogoCtrl.style.visibility = "hidden";
                if (popupCtrl) popupCtrl.style.setProperty("visibility", "hidden", "important");
                console.log(popupCtrl);
            }
        } else {
            mapboxLogoCtrl.classList.remove('shiftup');
        }
    }

    // Every time window is resized, resize directions to fit
    function resizeDirections(directionWindow, mapboxLogoCtrl) {
        // Works on both window resize and navbar collapse
        const resizeObserver = new ResizeObserver((entries) => {
            if ($(window).width() <= 799) {
                mapboxLogoCtrl.classList.add('shiftup');
                directionWindow.style.maxWidth = directionWindow.style.width = mapDiv.offsetWidth;
                directionWindow.style.maxHeight = directionWindow.style.height = (mapDiv.offsetHeight / 2);
                styleCollapsed();
            } else {
                mapboxLogoCtrl.classList.remove('shiftup');
                directionWindow.classList.remove('collapsed');
                directionWindow.style.maxWidth = directionWindow.style.width = "300px";
                directionWindow.style.maxHeight = directionWindow.style.height = "45vh";
                mapboxLogoCtrl.style.visibility = 'visible';
            }
        });
        let mapDiv = document.getElementById('map');
        resizeObserver.observe(mapDiv);
    }
</script>
@endsection