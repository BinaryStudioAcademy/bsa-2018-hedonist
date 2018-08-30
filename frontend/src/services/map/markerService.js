import markerGenerator from './markerGenerator';
import placeholderImg from '@/assets/placeholder_128x128.png';

const parser = (item) =>({
    id: item.id,
    name: item.localization[0].name,
    lng: item.longitude,
    lat: item.latitude,
    photoUrl: (item.photos && item.photos[0].img_url) || placeholderImg,
    category: item.category && item.category.name,
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
    };
};

const wrappedCreateMarker = cacher()(createMarker);

export default {
    clearMap(...markers) {
        markers.forEach((marker) => removeMarker(marker));
    },
    addMarkersFromPlaces(map,...places) {
        return places.map((item) => addMarker(map)(parser(item)));
    }
};