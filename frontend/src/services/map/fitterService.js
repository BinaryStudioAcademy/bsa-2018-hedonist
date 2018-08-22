const createSquare = (coordsObject) => {
    const lngDelta = Math.abs(coordsObject.maxLng - coordsObject.minLng);
    const latDelta = Math.abs(coordsObject.maxLat - coordsObject.minLat);
    const halfDelta = (lngDelta - latDelta) / 2;
    const squareCoord = {};
    if (halfDelta > 0) {
        squareCoord.minLat = coordsObject.minLat - halfDelta;
        squareCoord.maxLat = coordsObject.maxLat - halfDelta;
        squareCoord.minLng = coordsObject.minLng;
        squareCoord.maxLng = coordsObject.maxLng;
    } else if (halfDelta < 0) {
        squareCoord.minLng = coordsObject.minLng + halfDelta;
        squareCoord.maxLng = coordsObject.maxLng + halfDelta;
        squareCoord.minLat = coordsObject.minLat;
        squareCoord.maxLat = coordsObject.maxLat;
    } else {
        squareCoord.minLng = coordsObject.minLng;
        squareCoord.maxLng = coordsObject.maxLng;
        squareCoord.minLat = coordsObject.minLat;
        squareCoord.maxLat = coordsObject.maxLat;
    }
    return squareCoord;
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
    });
    const squareCoords = createSquare(coords);
    return [
        [squareCoords.minLng, squareCoords.minLat],
        [squareCoords.maxLng, squareCoords.maxLat]
    ];
};

export const fitMap = (map,...activeMarkers) => {
    map.fitBounds(parseCoordinates(...activeMarkers), {padding: 100, linear: true});
};

export default {fitMap};