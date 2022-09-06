@extends('includes.header')
<script src='https://api.mapbox.com/mapbox-gl-js/v2.10.0/mapbox-gl.js'></script>
<link href='https://api.mapbox.com/mapbox-gl-js/v2.10.0/mapbox-gl.css' rel='stylesheet' />
<script src="https://api.mapbox.com/mapbox-gl-js/plugins/mapbox-gl-directions/v4.1.0/mapbox-gl-directions.js"></script>
<link rel="stylesheet" href="https://api.mapbox.com/mapbox-gl-js/plugins/mapbox-gl-directions/v4.1.0/mapbox-gl-directions.css" type="text/css">

@section('body')
<div id="map"></div>


<script src="{{asset('js/mapbox/display.js')}}"></script>
<script src="https://unpkg.com/@mapbox/mapbox-sdk/umd/mapbox-sdk.min.js"></script>
<script>
    $(document).ready(() => {
        addMarkers();
        getLocationData();
    });

    function addMarkers() {
        let locations = JSON.parse('{!! json_encode($locations->values) !!}');
        const mapboxClient = mapboxSdk({
            accessToken: mapboxgl.accessToken
        });
        for (var i = 0; i < locations.length; i++) {
            for (var j = 0; j < locations[i].length; j++) {
                address = locations[i][2];

                mapboxClient.geocoding
                    .forwardGeocode({
                        query: address,
                        autocomplete: false,
                        limit: 1
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
                        // Create a marker and add it to the map.
                        new mapboxgl.Marker().setLngLat(feature.center).addTo(map);
                    });
            }
        }
    }
    function getLocationData() {
        if (navigator.geolocation) {
            navigator.geolocation.getCurrentPosition((position) => {
                console.log(position.coords.latitude, position.coords.longitude);
            });
        } else {
            console.log("Geolocation is not supported by this browser.");
        }
    }
</script>
@endsection