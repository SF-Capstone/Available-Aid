mapboxgl.accessToken = 'pk.eyJ1IjoiaWFud2Fzc29uIiwiYSI6ImNsN280emdwNTFwanEzb21xandmZ2VtYXQifQ.-YoFFnXFJ-XrxVZPA-ESKw';
const map = new mapboxgl.Map({
    container: 'map',                                               // container ID
    style: 'mapbox://styles/ianwasson/cl7o5942j000p14mucwks3teh',   // style URL
    center: [-122.669771, 45.518492],                               // starting position [lng, lat]
    zoom: 15                                                        // starting zoom
});

const nav = new mapboxgl.NavigationControl();
map.addControl(nav, 'top-right');

// add directions
let directions = new MapboxDirections({
    accessToken: mapboxgl.accessToken,
    interactive: false
});
map.addControl(directions, 'top-left');