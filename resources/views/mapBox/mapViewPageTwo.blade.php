
<script>
 const mapboxClient = mapboxSdk({
        accessToken: mapboxgl.accessToken
    });

    $(document).ready(() => {
        addGeocoder();
        addLoader();
        defaultWalking();
        shiftLocationButton();
        enlargeMapCanvas();
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
    // function isLoaded(container, mapDiv) {
    //     map.on('sourcedata', (e) => {
    //         if (e.sourceId === 'directions' && e.isSourceLoaded) {
    //             container.style.visibility = 'hidden';
    //             mapDiv.style.visibility = 'visible';
    //         }
    //     });
    // }

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



   

    // Increase map canvas height to ensure
    // the top doesn't get cut off
    function enlargeMapCanvas() {
        const resizeObserver = new ResizeObserver((entries) => {
            let mapboxCanvas = document.querySelector(".mapboxgl-canvas");
            mapboxCanvas.style.height = (mapboxCanvas.offsetHeight + 38) + 'px';
        });
        let mapDiv = document.getElementById('map');
        resizeObserver.observe(mapDiv);
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


</script>
