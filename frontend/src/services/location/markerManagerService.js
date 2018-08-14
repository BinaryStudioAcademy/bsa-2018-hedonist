class MarkerManagerService {
    constructor(map, parser = null) {
        this._map = map;
        this._parser = parser || MarkerManagerService._getDefaultParser();
        this._markersPool = new Map();
        this._activeMarkers = new Map();
    }

    setMarkers(...items) {
        let converted = items.map((item) => this._parser(item));
        this._removeMarkers(converted);
        converted.forEach((item) => {
            if(!this._activeMarkers.has(item.id)) {
                if(this._markersPool.has(item.id)){
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
                let marker = this._activeMarkers.get(markerId);
                marker.remove();
                this._activeMarkers.delete(markerId);
            }
        }
    }

    _createMarker(markerData){
        console.log('creating marker');
        let marker = new mapboxgl.Marker();
        marker.setLngLat([markerData.lng,markerData.lat]);
        marker.addTo(this._map);
        this._activeMarkers.set(markerData.id,marker);
        this._markersPool.set(markerData.id,marker);
    }

    _restoreMarker(markerData){
        console.log('Loading from cache...');
        let marker = this._markersPool.get(markerData.id);
        marker.addTo(this._map);
        this._activeMarkers.set(markerData.id,marker);
    }

    static _getDefaultParser() {
        return (item) => ({
            id: item.id,
            name: item.name,
            lng: item.longitude,
            lat: item.latitude
        })
    }
}

export default MarkerManagerService;