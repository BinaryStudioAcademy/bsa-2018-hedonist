import MarkerGenerator from './markerGeneratorService';
import geojsonExtent from '@mapbox/geojson-extent';
import placeholderImg from '@/assets/placeholder_128x128.png';


class MarkerManagerService {
    constructor(map, parser = null) {
        this._map = map;
        this._parser = parser || MarkerManagerService._getDefaultParser();
        this._markersPool = new Map();
        this._activeMarkers = new Map();
        this._GeoJSON = {
            'type': 'FeatureCollection',
            'features': []
        };
        this.lastMarkerCoords = {
            latitude: null,
            longitude: null
        };
    }

    setMarkers(items) {
        let markersData = items.map((item) => this._parser(item));
        this._removeMarkers(markersData);
        markersData.forEach((item) => {
            if (!this._activeMarkers.has(item.id)) {
                if (this._markersPool.has(item.id)) {
                    this._restoreMarker(item);
                } else {
                    this._createMarker(item);
                }
                this._addGeoJsonFeature(
                    item.lng,
                    item.lat
                );
                this.lastMarkerCoords.latitude = item.lat;
                this.lastMarkerCoords.longitude = item.lng;
            }
        });
    }

    getCurrentCenter() {
        return this.lastMarkerCoords;
    }

    fitMarkersOnMap() {
        let extent = geojsonExtent(this._GeoJSON);

        this._map.fitBounds(extent, {padding: 50});
    }

    _addGeoJsonFeature(lng, lat) {
        this._GeoJSON.features.push({
            'type': 'Feature',
            'properties': {},
            'geometry': {
                'type': 'Point',
                'coordinates': [
                    lng,
                    lat
                ]
            }
        });
    }

    _removeMarkers(markerData) {
        for (let markerId of this._activeMarkers.keys()) {
            if (!markerData.find((item) => item.id === markerId)) {
                let object = this._activeMarkers.get(markerId);
                object.marker.remove();
                this._activeMarkers.delete(markerId);
            }
        }
    }

    _createMarker(markerData) {
        let marker = MarkerGenerator.generateMarker(markerData);
        marker.addTo(this._map);
        this._activeMarkers.set(markerData.id, {marker, markerData});
        this._markersPool.set(markerData.id, {marker, markerData});
    }

    _restoreMarker(markerData) {
        let object = this._markersPool.get(markerData.id);
        object.marker.addTo(this._map);
        this._activeMarkers.set(markerData.id, object.marker);
    }

    static _getDefaultParser() {
        return (item) => ({
            id: item.id,
            name: item.localization[0].name,
            lng: item.longitude,
            lat: item.latitude,
            photoUrl: item.photoUrl || placeholderImg,
            address: item.address
        });
    }
}

export default MarkerManagerService;