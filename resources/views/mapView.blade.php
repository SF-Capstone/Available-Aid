@extends('includes.header')
<script src='https://api.mapbox.com/mapbox-gl-js/v2.10.0/mapbox-gl.js'></script>
<link href='https://api.mapbox.com/mapbox-gl-js/v2.10.0/mapbox-gl.css' rel='stylesheet' />
<script src="https://api.mapbox.com/mapbox-gl-js/plugins/mapbox-gl-directions/v4.1.0/mapbox-gl-directions.js"></script>
<link rel="stylesheet" href="https://api.mapbox.com/mapbox-gl-js/plugins/mapbox-gl-directions/v4.1.0/mapbox-gl-directions.css" type="text/css">
<style>
    body,
    html {
        height: 100%;
        display: flex;
        flex-direction: column;
        justify-content: center;
    }
    .loaderContainer {
        display: flex;
        justify-content: center;
        align-items: center;
    }
    .loader {
        border: 16px solid #f3f3f3;
        border-top: 16px solid #576f72;
        border-radius: 50%;
        width: 120px;
        height: 120px;
        animation: spin 2s linear infinite;
    }
    @keyframes spin {
        0% {
            transform: rotate(0deg);
        }
        100% {
            transform: rotate(360deg);
        }
    }
    .mapbox-directions-destination {
        display: none;
    }
    .directions-icon-reverse {
        display: none;
    }
    .mapbox-directions-instructions,
    .mapbox-directions-instructions-wrapper {
        height: calc(100% - 38px);
    }
    .mapboxgl-popup {
        max-width: 200px;
    }
    .mapboxgl-popup-content {
        text-align: center;
        font-family: 'Open Sans', sans-serif;
    }
    .mapboxgl-user-location,
    .mapboxgl-user-location-accuracy-circle {
        display: none;
    }
    .mapboxgl-ctrl button:not(:disabled):hover {
        background-color: #fff;
    }
    /* Mapbox screen size "medium" and below */
    @media only screen and (max-width: 799px) {
        /* Full screen map */
        #map {
            height: 100%;
        }
        .directions-control.directions-control-inputs {
            min-width: 300px;
        }
        .mapboxgl-ctrl-bottom-left {
            bottom: 0;
            position: absolute;
        }
        .directions-control.directions-control-instructions {
            max-width: none;
            min-width: 0%;
            width: auto;
            position: absolute;
            bottom: 0;
            pointer-events: auto;
        }
        .directions-control.directions-control-directions {
            margin: 0;
            -webkit-transition: max-height 0.3s ease-out;
            -moz-transition: max-height 0.3s ease-out;
            -o-transition: max-height 0.3s ease-out;
            -ms-transition: max-height 0.3s ease-out;
            transition: max-height 0.3s ease-out;
            position: relative;
        }
        .directions-control.directions-control-directions.collapsed {
            max-height: 38px !important;
        }
        .dirToggle {
            position: absolute;
            top: 0.5rem;
            left: 50%;
            transform: translate(-50%, 0);
            z-index: 3;
        }
        .mapboxgl-ctrl-bottom-left .mapboxgl-ctrl.shiftup {
            margin: 0 0 48px 10px;
        }
        .mapboxgl-ctrl.mapboxgl-ctrl-attrib.shiftup {
            margin: 0 10px 48px 0;
        }
    }
    /* Mapbox screen size "large" and up */
    @media only screen and (min-width: 800px) {
        /* Center map on page */
        #map {
            margin: auto;
            height: 75vh;
            width: 75vw;
        }
        .mapboxgl-ctrl-top-left {
            z-index: 99;
        }
        .mapboxgl-ctrl-bottom-left {
            position: absolute;
            top: 0;
            height: 100%;
        }
        .mapboxgl-ctrl-bottom-left .mapboxgl-ctrl {
            bottom: 0;
            position: absolute;
        }
        .directions-control.directions-control-instructions {
            top: 0;
            margin-top: 97px;
            margin-left: 10px;
            pointer-events: auto;
        }
        .dirToggle {
            display: none;
        }
    }
</style>

@section('body')
<div id="map"></div>

<script src="{{asset('js/mapbox/display.js')}}"></script>
<script src="https://unpkg.com/@mapbox/mapbox-sdk/umd/mapbox-sdk.min.js"></script>
<script>
    const mapboxClient = mapboxSdk({
        accessToken: mapboxgl.accessToken
    });
    $(document).ready(() => {
        addLoader();
        setLocation();
        setShelter();
        observeDirections();
    });
    // Add a loading spinner
    function addLoader() {
        let container = document.createElement('div')
        container.id = 'loadContainer';
        container.className = 'loaderContainer';
        let loader = document.createElement('img');
        loader.id = 'loading';
        loader.className = 'loader'
        container.appendChild(loader)
        let map = document.getElementById('map');
        map.appendChild(container);
        container.style.maxHeight = container.style.height = map.offsetHeight;
        container.style.maxWidth = container.style.width = map.offsetWidth;
        map.style.visibility = 'hidden';
        container.style.visibility = 'visible';
        isLoaded(container);
    }
    // Display map if data is loaded
    function isLoaded(container) {
        let mapElement = document.getElementById('map');
        map.on('sourcedata', (e) => {
            if (e.sourceId === 'directions' && e.isSourceLoaded) {
                container.style.visibility = 'hidden';
                mapElement.style.visibility = 'visible';
            }
        });
    }
    // Sets the user's origin to their geolocated position
    function setLocation() {
        geolocate.on('geolocate', function(event) {
            getLocation(event)
                .then(location => {
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
    // Only runs "map directions" related functions once it has been added to DOM
    function observeDirections() {
        const targetNode = document.querySelector(".directions-control-instructions");
        // Call observer if target node had children added/removed
        const config = {
            childList: true,
        };
        const callback = (mutationList, observer) => {
            responsiveDirections();
        };
        const observer = new MutationObserver(callback);
        observer.observe(targetNode, config);
    }
    // Wrapper for responsive directions functions
    function responsiveDirections() {
        let directionWindow = document.querySelector(".directions-control-directions");
        let mapboxControls = {
            // navigationCtrl: document.querySelector(".mapboxgl-ctrl-group"),
            mapboxLogoCtrl: document.querySelector(".mapboxgl-ctrl-bottom-left").querySelector(".mapboxgl-ctrl"),
            attributeCtrl: document.querySelector(".mapboxgl-ctrl.mapboxgl-ctrl-attrib"),
            popupCtrl: document.querySelector(".mapboxgl-popup")
        };
        // If map directions are currently being displayed
        if (directionWindow) {
            moveDirectionWindow();
            mapboxControls.mapboxLogoCtrl.classList.add('shiftup');
            mapboxControls.attributeCtrl.classList.add('shiftup');
            directionWindow.classList.add('collapsed');
            addDirectionToggle(directionWindow, mapboxControls);
            toggleDirections(directionWindow, mapboxControls);
            resizeDirections(directionWindow, mapboxControls);
            $(window).trigger('resize');
        } else {
            mapboxControls.mapboxLogoCtrl.classList.remove('shiftup')
            mapboxControls.attributeCtrl.classList.remove('shiftup');
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
    function addDirectionToggle(directionWindow, mapboxControls) {
        let directionToggle = document.createElement('button');
        directionToggle.id = 'directionToggle';
        directionToggle.className = 'dirToggle';
        directionToggle.textContent = 'Toggle directions';
        const directionToggleExists = document.getElementById("directionToggle");
        if (!directionToggleExists) {
            directionWindow.appendChild(directionToggle);
        }
        directionToggle.addEventListener('click', function() {
            toggleDirections(directionWindow, mapboxControls);
        })
    }
    // Toggles direction window and other map controls on/off
    function toggleDirections(directionWindow, mapboxControls) {
        directionWindow.classList.toggle('collapsed');
        if (mapboxControls.popupCtrl) mapboxControls.popupCtrl.style.display = "none";
        if (directionWindow.classList.contains('collapsed')) {
            directionWindow.addEventListener("transitionend", function visible() {
                directionWindow.removeEventListener("transitionend", visible);
                mapboxControls.mapboxLogoCtrl.style.visibility = "visible";
                mapboxControls.attributeCtrl.style.visibility = "visible";
            });
        } else {
            mapboxControls.mapboxLogoCtrl.style.visibility = "hidden";
            mapboxControls.attributeCtrl.style.visibility = "hidden";
        }
    }
    // Every time window is resized, resizes directions
    function resizeDirections(directionWindow, mapboxControls) {
        let map = document.getElementById('map');
        // Works on both window resize and navbar collapse
        const resizeObserver = new ResizeObserver((entries) => {
            if ($(window).width() <= 799) {
                mapboxControls.mapboxLogoCtrl.classList.add('shiftup');
                mapboxControls.attributeCtrl.classList.add('shiftup');
                directionWindow.classList.toggle('collapsed');
                directionWindow.style.maxWidth = directionWindow.style.width = map.offsetWidth;
                directionWindow.style.maxHeight = directionWindow.style.height = (map.offsetHeight / 2);
                toggleDirections(directionWindow, mapboxControls);
            } else {
                mapboxControls.mapboxLogoCtrl.classList.remove('shiftup');
                mapboxControls.attributeCtrl.classList.remove('shiftup');
                directionWindow.classList.remove('collapsed');
                directionWindow.style.maxWidth = directionWindow.style.width = "300px";
                directionWindow.style.maxHeight = directionWindow.style.height = "45vh";
                mapboxControls.attributeCtrl.style.visibility = 'visible';
                mapboxControls.mapboxLogoCtrl.style.visibility = 'visible';
            }
        });
        resizeObserver.observe(map);
    }
</script>
@endsection