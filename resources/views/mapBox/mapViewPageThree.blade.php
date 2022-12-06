<script>

    // Calls functions that make the map directions responsive
    function responsiveDirections() {
        let directionWindow = document.querySelector(".directions-control-directions");

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
            }
        } else {
            mapboxLogoCtrl.classList.remove('shiftup');
        }
    }
