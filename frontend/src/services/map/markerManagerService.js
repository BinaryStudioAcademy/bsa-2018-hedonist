import MarkerGenerator from './markerGeneratorService';
import placeholderImg from '../../assets/placeholder_128x128.png';

const defaultParser = (item) => ({
    id: item.id,
    name: item.localization[0].name,
    lng: item.longitude,
    lat: item.latitude,
    // TODO set place photo url
    photoUrl: item.photoUrl || placeholderImg,
    address: item.address
});

const removeMarkers = (activeMap, ...markers) => {
    for (let markerId of activeMap.keys()) {
        if (!markers.find((item) => item.id === markerId)) {
            let object = activeMap.get(markerId);
            object.marker.remove();
            activeMap.delete(markerId);
        }
    }
};

const addMarkerToMap = map => marker => {
    marker.addTo(map);
};

const createMarker = markerData => ({markerData, marker: MarkerGenerator.generateMarker(markerData)});

const setMarkers = parser => (mapAdder, markerCreator, markerRemover) => {
    const poolMap = new Map();
    const activeMap = new Map();
    return (...markers) => {
        let markersData = markers.map((item) => parser(item));
        markerRemover(activeMap, ...markersData);
        markersData.forEach((item) => {
            if (!activeMap.has(item.id)) {
                if (poolMap.has(item.id)) {
                    const object = poolMap.get(item.id);
                    mapAdder(object.marker);
                    activeMap.set(item.id, object);
                } else {
                    const object = markerCreator(item);
                    mapAdder(object.marker);
                    activeMap.set(item.id, object);
                    poolMap.set(item.id, object);
                }
            }
        });
        return activeMap;
    };
};

const createSquare = (coordsObject) => {
    const lngDelta = Math.abs(coordsObject.maxLng - coordsObject.minLng);
    const latDelta = Math.abs(coordsObject.maxLat - coordsObject.minLat);
    const globalDelta = lngDelta - latDelta;
    if (globalDelta > 0) {
        coordsObject.minLat -= globalDelta / 2;
        coordsObject.maxLat -= globalDelta / 2;
    }
    if (globalDelta < 0) {
        coordsObject.minLng += globalDelta / 2;
        coordsObject.maxLng += globalDelta / 2;
    }
    return coordsObject;
};

const parseCoordinates = (...markers) => {
    const coords = markers.reduce((previous, current) => {
        const item = {};
        item.maxLat = previous.maxLat > current.markerData.lat ? previous.maxLat : current.markerData.lat;
        item.minLat = previous.minLat < current.markerData.lat ? previous.minLat : current.markerData.lat;
        item.maxLng = previous.maxLng > current.markerData.lng ? previous.maxLng : current.markerData.lng;
        item.minLng = previous.minLng < current.markerData.lat ? previous.minLng : current.markerData.lng;
        return item;
    });
    const squareCoords = createSquare(coords);
    return [
        [squareCoords.minLng, squareCoords.minLat],
        [squareCoords.maxLng, squareCoords.maxLat]
    ];
};

const mapFitter = map => (...activeMarkersObjects) => {
    map.fitBounds(parseCoordinates(...activeMarkersObjects), {padding: 100, linear: true});
};

const mapUpdater = (parser = defaultParser) => (map,shouldFit) => {
    const handleUpdate = setMarkers(parser)(addMarkerToMap(map), createMarker, removeMarkers);
    const fitter = mapFitter(map);
    return (...markers) => {
        const activeMap = handleUpdate(...markers);
        if(shouldFit) {
            fitter(...activeMap.values());
        }
    };
};

export default mapUpdater;