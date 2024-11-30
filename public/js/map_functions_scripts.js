function addMarker(map, lat, lng, label) {
    // Create a marker and bind a popup with a delete option
    const marker = L.marker([lat, lng]).addTo(map);
    marker.bindPopup(`
        ${label}<br>
        <button class="btn btn-danger" onclick="deleteMarker(${marker._leaflet_id})">Delete</button>
    `).openPopup();
    return marker;
}

// Function to delete the marker by its Leaflet ID
function deleteMarker(markerId) {
    const marker = map._layers[markerId];
    if (marker) {
        map.removeLayer(marker);
        // Remove reference from either pickMarker or dropMarker if necessary
        if (pickMarker && pickMarker._leaflet_id === markerId) pickMarker = null;
        if (dropMarker && dropMarker._leaflet_id === markerId) dropMarker = null;
    }
}

// function to add pick up marker and drop marker
function addPickDropMarkers() {
    let pickMarker, dropMarker;  // Store references for pick-up and drop-off markers
    
    map.on('click', function(e) {
        console.log(e.latlng);
    
        if (!pickMarker) {
            // Create the pick-up marker with a delete option in the popup
            pickMarker = addMarker(map, e.latlng.lat, e.latlng.lng, "Pick-up");
        } else if (!dropMarker) {
            // Create the drop-off marker with a delete option in the popup
            dropMarker = addMarker(map, e.latlng.lat, e.latlng.lng, "Drop-off");
        }
    });
}

function addCircle(map,lat,lng,radius,color = 'red',fillColor = 'red',fillOpacity = '0.5'){
    L.circle([lat, lng], {
        color: color,
        fillColor: fillColor,
        fillOpacity: fillOpacity,
        radius: radius
    }).addTo(map);
}
// addCircle(51.508, -0.11,500);

function addPolygon(map,arrayOfLatlngs){
    L.polygon(arrayOfLatlngs).addTo(map);
}
// addPolygon([
//     [51.509, -0.08],
//     [51.503, -0.06],
//     [51.51, -0.047]
// ]);

// marker.bindPopup("<b>Hello world!</b><br>I am a popup.").openPopup();
// circle.bindPopup("I am a circle.");
// polygon.bindPopup("I am a polygon.");

function locateMe(){
    // Check if Geolocation is available
    if ("geolocation" in navigator) {
        navigator.geolocation.getCurrentPosition(
            function (position) {
                const { latitude, longitude, accuracy } = position.coords;

                // Set the map view to the user's location
                map.setView([latitude, longitude], 13);

                // Add a marker for the user's location
                const marker = addMarker(map,latitude, longitude);
                marker.bindPopup("You are here!").openPopup();

                // Add a circle around the location with the accuracy radius
                const accuracyCircle = L.circle([latitude, longitude], {
                    radius: accuracy, // Radius in meters
                    color: 'blue',
                    fillColor: '#blue',
                    fillOpacity: 0.2
                }).addTo(map);

            },
            function (error) {
                console.error("Error getting location:", error);
            },
            { enableHighAccuracy: true } // High accuracy mode
        );
    } else {
        console.log("Geolocation is not supported by your browser.");
    }
}