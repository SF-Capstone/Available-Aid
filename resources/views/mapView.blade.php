@extends('includes.header')
<script src='https://api.mapbox.com/mapbox-gl-js/v2.10.0/mapbox-gl.js'></script>
<link href='https://api.mapbox.com/mapbox-gl-js/v2.10.0/mapbox-gl.css' rel='stylesheet' />
<script src="https://api.mapbox.com/mapbox-gl-js/plugins/mapbox-gl-directions/v4.1.0/mapbox-gl-directions.js"></script>
<link rel="stylesheet" href="https://api.mapbox.com/mapbox-gl-js/plugins/mapbox-gl-directions/v4.1.0/mapbox-gl-directions.css" type="text/css">
<style>
    .mapboxgl-popup {
        max-width: 200px;
    }

    .mapboxgl-popup-content {
        text-align: center;
        font-family: 'Open Sans', sans-serif;
    }

    .directionButton {
        position: absolute;
        top: 10px;
        left: 50%;
        transform: translate(-50%, 0);
        z-index: 3;
    }

    /* Screen size "medium" and below as defined by Mapbox documentation */
    @media only screen and (max-width: 799px) {

        .directions-control.directions-control-instructions,
        .directions-control.directions-control-directions,
        .mapbox-directions-instructions {
            height: 100%;
        }

        .directions-control.directions-control-directions {
            max-height: 100%;
            margin: 0;
        }

        .mapboxgl-ctrl-top-left .mapboxgl-ctrl {
            margin: 0;
        }

        .mapboxgl-ctrl-directions {
            max-width: none;
            min-width: 0%
        }
    }

    /* Screen size "large" and up as defined by Mapbox documentation*/
    @media only screen and (min-width: 800px) {
        .directionButton {
            display: none;
        }
    }
</style>

@section('body')
<div id="map"></div>

<script src="{{asset('js/mapbox/display.js')}}"></script>
<script src="https://unpkg.com/@mapbox/mapbox-sdk/umd/mapbox-sdk.min.js"></script>
<script>
    $(document).ready(() => {
        addShelters();
        setOrigin();
    });
    const mapboxClient = mapboxSdk({
        accessToken: mapboxgl.accessToken
    });

    // 
    function addShelters() {
        const locations = JSON.parse('{!! json_encode($locations->values) !!}');
        locations.forEach(addMarkers);
    }

    function setOrigin() {
        if (navigator.geolocation) {
            navigator.geolocation.getCurrentPosition((position) => {
                directions.setOrigin([position.coords.longitude, position.coords.latitude]);
            });
            // User has to manually input their location
        } else {
            console.log("Geolocation is not supported by this browser.");
        }
    }

    function responsiveDirections() {
        let map = document.getElementById('map');
        let mapboxControls = {
            directionControl: document.querySelector(".mapboxgl-ctrl-directions"),
            navigationControl: document.querySelector(".mapboxgl-ctrl.mapboxgl-ctrl-group"),
            mapboxLogoText: document.querySelector(".mapboxgl-ctrl-bottom-left").querySelector(".mapboxgl-ctrl"),
            popups: document.querySelector(".mapboxgl-popup")
        };

        // Create a button that toggles directions on click
        addDirectionButton(map, mapboxControls);

        // Size directions to fit map initially and on resize
        mapboxControls.directionControl.style.display = 'none'
        toggleDirections(mapboxControls);
        resizeDirections(map, mapboxControls);
        $(window).trigger('resize');
    }

    function addDirectionButton(map, mapboxControls) {
        let directionToggle = document.createElement('button');
        directionToggle.id = 'dirButton';
        directionToggle.className = 'directionButton';
        directionToggle.textContent = 'Toggle directions';

        const directionToggleExists = document.getElementById("dirButton");
        if (!directionToggleExists) {
            map.appendChild(directionToggle);
        }
        
        directionToggle.addEventListener('click', function() {
            toggleDirections(mapboxControls);
        });
    }

    function toggleDirections(mapboxControls) {
        mapboxControls.popups = document.querySelector(".mapboxgl-popup");
        if (mapboxControls.directionControl.style.display === "none") {
            mapboxControls.directionControl.style.display = "block";
            mapboxControls.navigationControl.style.display = 'none';
            mapboxControls.mapboxLogoText.style.display = 'none';
            if (mapboxControls.popups) mapboxControls.popups.style.display = 'none';
        } else {
            mapboxControls.directionControl.style.display = 'none';
            mapboxControls.navigationControl.style.display = 'block';
            mapboxControls.mapboxLogoText.style.display = 'block';
            if (mapboxControls.popups) mapboxControls.popups.style.display = 'block';
        }
    }

    // Every time window is resized, resize directions
    function resizeDirections(map, mapboxControls) {
        $(window).on("resize", function() {
            if ($(window).width() <= 799) {
                mapboxControls.directionControl.style.width = map.offsetWidth;
                mapboxControls.directionControl.style.height = map.offsetHeight;
                mapboxControls.directionControl.style.display = mapboxControls.directionControl.style.display === "none" ? "block" : "none"
                toggleDirections(mapboxControls);
            } else {
                mapboxControls.directionControl.style.display = 'block';
                mapboxControls.navigationControl.style.display = 'block';
                mapboxControls.mapboxLogoText.style.display = 'block';
                if (mapboxControls.popups) mapboxControls.popups.style.display = 'block';
            }
        });
    }

    function setDestination(long, lat) {
        directions.setDestination([long, lat]);
        responsiveDirections();
    }

    function addMarkers(info, index) {
        const name = info[0];
        const phone = info[1];
        const address = info[2];
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
                    // Link to info page here
                    .setHTML(
                        `<h3>${name}</h3>
                        <button onclick="setDestination(${long}, ${lat})">Directions</button>
                        <p>Link to info</p>`
                    )
                ).addTo(map);
            });
    }
</script>
@endsection