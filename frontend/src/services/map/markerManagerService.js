import MarkerGenerator from './markerGeneratorService';

class MarkerManagerService {
    constructor(map, parser = null) {
        this._map = map;
        this._parser = parser || MarkerManagerService._getDefaultParser();
        this._markersPool = new Map();
        this._activeMarkers = new Map();
    }

    setMarkers(...items) {
        let markersData = items.map((item) => this._parser(item));
        this._removeMarkers(markersData);
        markersData.forEach((item) => {
            if (!this._activeMarkers.has(item.id)) {
                if (this._markersPool.has(item.id)) {
                    this._restoreMarker(item);
                } else {
                    this._createMarker(item);
                }
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
            name: item.name,
            lng: item.longitude,
            lat: item.latitude,
            photoUrl: item.photo.url,
            address: item.address
        });
    }
}

export default MarkerManagerService;