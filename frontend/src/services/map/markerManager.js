import markerGenerator from './markerGenerator';
import placeholderImg from "../../assets/placeholder_128x128.png";

const parser = (item) => ({
    id: item.id,
    name: item.localization[0].name,
    lng: item.longitude,
    lat: item.latitude,
    // TODO set place photo url
    photoUrl: item.photoUrl || placeholderImg,
    address: item.address
});

const removeMarker = (marker) => {
    marker.remove();
};

const addMarker = (map) => (markerData) => {
    const marker = wrappedCreateMarker(markerData);
    marker.addTo(map);
    return marker;
};

const createMarker = (markerData) => {
    return markerGenerator.generateDefaultMarker(markerData);
};

const cacher = () => {
    const cache = {};
    return (funcToCache) => (data) => {
        if (cache[data.id] !== undefined) {
            return cache[data.id];
        }
        const result = funcToCache(data);
        cache[data.id] = result;
        return result;
    }
};

const wrappedCreateMarker = cacher()(createMarker);

const getManager = (map) => {
    const activeMarkers = [];
    return {
        clearMap(...markers){
            markers.forEach((marker) => removeMarker(marker))
        },
        addMarkersFromPlaces(...places){
            return places.map((item) => addMarker(map)(parser(item)));
        }
    };
};

export default {getManager};