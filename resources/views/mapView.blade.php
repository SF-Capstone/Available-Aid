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
</style>

@section('body')
<div id="map"></div>

<script src="{{asset('js/mapbox/display.js')}}"></script>
<script src="https://unpkg.com/@mapbox/mapbox-sdk/umd/mapbox-sdk.min.js"></script>
<script>
    $(document).ready(() => {
        setOrigin();
        getShelters();
    });
    const mapboxClient = mapboxSdk({
        accessToken: mapboxgl.accessToken
    });

    function getShelters() {
        let locations = JSON.parse('{!! json_encode($locations->values) !!}');
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
            return null;
        }
    }

    function setDestination(long, lat) {
        console.log("coordintes:", long, lat);
        directions.setDestination([long, lat]);
    }

    function addMarkers(info, index) {
        var name = info[0];
        var phone = info[1];
        var address = info[2];
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
                var long = feature.center[0];
                var lat = feature.center[1];
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