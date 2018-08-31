const parseFirstMarker = (marker) => {
    const coords = marker.getLngLat();
    return {
        maxLng: coords.lng,
        minLng: coords.lng,
        maxLat: coords.lat,
        minLat: coords.lat
    };
};

const parseCoordinates = (...markers) => {
    const coords = markers.reduce((previous, current) => {
        const item = {};
        const currentCoords = current.getLngLat();
        item.maxLat = previous.maxLat > currentCoords.lat ? previous.maxLat : currentCoords.lat;
        item.minLat = previous.minLat < currentCoords.lat ? previous.minLat : currentCoords.lat;
        item.maxLng = previous.maxLng > currentCoords.lng ? previous.maxLng : currentCoords.lng;
        item.minLng = previous.minLng < currentCoords.lng ? previous.minLng : currentCoords.lng;
        return item;
    }, parseFirstMarker(markers[0]));
    return [
        [coords.minLng, coords.minLat],
        [coords.maxLng, coords.maxLat]
    ];
};

export const fitMap = (map, ...activeMarkers) => {
    if (activeMarkers.length > 1) {
        map.fitBounds(parseCoordinates(...activeMarkers), {padding: 100, linear: true, maxZoom: 17});
    } else if (activeMarkers.length === 1) {
        map.flyTo({center:activeMarkers[0].getLngLat(), zoom:17});
    }
};

export default {fitMap};