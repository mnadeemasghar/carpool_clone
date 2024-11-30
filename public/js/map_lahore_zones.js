function drawZones(center, rows = 8, columns = 10) {
    // Calculate latitude and longitude increments based on a grid size
    const latIncrement = 0.04; // Adjust increment to change the size of each cell (in degrees)
    const lngIncrement = 0.04; // Adjust increment to change the size of each cell (in degrees)

    // Calculate the starting point for the grid
    const startLat = center.lat - (latIncrement * rows) / 2;
    const startLng = center.lng - (lngIncrement * columns) / 2;

    const zones = [];

    for (let row = 0; row < rows; row++) {
        for (let col = 0; col < columns; col++) {
            const south = startLat + row * latIncrement;
            const north = south + latIncrement;
            const west = startLng + col * lngIncrement;
            const east = west + lngIncrement;

            // Define the polygon for each zone
            const zone = [
                { lat: south, lng: west },
                { lat: north, lng: west },
                { lat: north, lng: east },
                { lat: south, lng: east },
                { lat: south, lng: west }, // Close the polygon
            ];
            zones.push(zone);
        }
    }

    // Add each zone to the map
    zones.forEach((zone) => {
        addPolygon(map, zone);
    });
}
