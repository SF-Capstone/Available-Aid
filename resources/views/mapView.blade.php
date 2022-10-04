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

    .mapboxgl-popup {
        max-width: 200px;
    }

    .mapboxgl-popup-content {
        text-align: center;
        font-family: 'Open Sans', sans-serif;
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

        .mapboxgl-ctrl-top-left {
            top: auto;
            left: auto;
            bottom: 0;
        }

        .mapboxgl-ctrl-top-left .mapboxgl-ctrl {
            margin: 0;
        }

        .mapboxgl-ctrl-directions {
            max-width: none;
            min-width: 0%;
            width: auto;
            margin: 0;
            bottom: 0;
        }

        .directions-control.directions-control-directions {
            margin: 0;
            bottom: 0;
            top: auto;
            right: auto;
            transition: max-height 0.3s ease-out;
        }

        .directions-control.directions-control-directions.collapsed {
            max-height: 38px !important;
        }

        .mapbox-directions-instructions,
        .mapbox-directions-instructions-wrapper {
            height: calc(100% - 38px);
        }

        .dirToggle {
            position: absolute;
            top: 0.5rem;
            left: 50%;
            transform: translate(-50%, 0);
            z-index: 3;
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
        getShelter();
        setStart();
        observeDirections();
    });

    // Gets shelter data from controller
    function getShelter() {
        const shelterInfo = JSON.parse('{!! json_encode($result) !!}');
        const name = shelterInfo['Shelter Name'];
        // const contact = shelterInfo['Contact Info'];
        const address = shelterInfo['Location'];
        addMarker(name, address);
    }

    // Places a marker on the map where the shelter is located
    function addMarker(name, address) {
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
                    return;
                }
                const feature = response.body.features[0];
                const long = feature.center[0];
                const lat = feature.center[1];
                // Create a marker and add it to the map.
                new mapboxgl.Marker().setLngLat(feature.center).setPopup(
                    new mapboxgl.Popup({
                        offset: 25
                    })
                    .setHTML(
                        `<h3>${name}</h3>
                        <button onclick="setDest(${long}, ${lat})">Directions</button>`
                    )
                ).addTo(map);
            });
    }

    // Sets the user's origin to their geolocated position
    function setStart() {
        if (navigator.geolocation) {
            navigator.geolocation.getCurrentPosition((position) => {
                directions.setOrigin([position.coords.longitude, position.coords.latitude]);
            });
            // User will need to manually input their location
        } else {
            console.log("Geolocation is not supported by this browser.");
        }
    }

    // Sets the destination when called from button click
    function setDest(long, lat) {
        directions.setDestination([long, lat]);
    }

    // Only runs "map directions" related functions once it has been added to DOM
    function observeDirections() {
        const targetNode = document.querySelector(".directions-control-instructions");

        // Call observer if target node had children added/removed
        const config = {
            childList: true,
        };

        const callback = (mutationList, observer) => {
            observer.disconnect();
            responsiveDirections();
        };

        const observer = new MutationObserver(callback);
        observer.observe(targetNode, config);
    }

    // Wrapper function for responsive directions functions
    function responsiveDirections() {
        let directionWindow = document.querySelector(".directions-control-directions");
        directionWindow.classList.add('collapsed');

        let mapboxControls = {
            // navigationCtrl: document.querySelector(".mapboxgl-ctrl-group"),
            mapboxLogoCtrl: document.querySelector(".mapboxgl-ctrl-bottom-left").querySelector(".mapboxgl-ctrl"),
            attributeCtrl: document.querySelector(".mapboxgl-ctrl.mapboxgl-ctrl-attrib"),
            popupCtrl: document.querySelector(".mapboxgl-popup")
        };

        addDirectionToggle(directionWindow, mapboxControls);
        toggleDirections(directionWindow, mapboxControls);
        resizeDirections(directionWindow, mapboxControls);
        $(window).trigger('resize');
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
        mapboxControls.mapboxLogoCtrl.style.visibility = directionWindow.classList.contains('collapsed') ? "visible" : "hidden";
        mapboxControls.attributeCtrl.style.visibility = directionWindow.classList.contains('collapsed') ? "visible" : "hidden";
        if (mapboxControls.popupCtrl) mapboxControls.popupCtrl.style.display = "none";
    }

    // Every time window is resized, resizes directions
    function resizeDirections(directionWindow, mapboxControls) {
        let map = document.getElementById('map');
        // Works on both window resize and navbar collapse
        const resizeObserver = new ResizeObserver((entries) => {
            if ($(window).width() <= 799) {
                directionWindow.style.maxWidth = directionWindow.style.width = map.offsetWidth;
                directionWindow.style.maxHeight = directionWindow.style.height = (map.offsetHeight / 2);
                directionWindow.classList.toggle('collapsed');
                toggleDirections(directionWindow, mapboxControls);
            } else {
                directionWindow.style.maxWidth = directionWindow.style.width = "300px";
                directionWindow.style.maxHeight = "none";
                directionWindow.style.height = ((window.innerHeight / 2) + 38) + "px";
                mapboxControls.mapboxLogoCtrl.style.visibility = 'visible';
                mapboxControls.attributeCtrl.style.visibility = 'visible';
            }
        });
        resizeObserver.observe(map);
    }
</script>
@endsection