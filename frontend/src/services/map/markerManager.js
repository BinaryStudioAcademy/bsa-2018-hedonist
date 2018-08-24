import  markerService from './markerService';
import fitterService from './fitterService';

const getService = (map) => {
    let activeMarkers = [];
    return {
        setMarkersFromPlaces(...places){
            markerService.clearMap(...activeMarkers);
            activeMarkers = markerService.addMarkersFromPlaces(map,...places);
            return activeMarkers;
        },
        setMarkersFromPlacesAndFit(...places){
            const markers = this.setMarkersFromPlaces(...places);
            fitterService.fitMap(map, ...markers);
            return markers;
        }
    };
};

export default {getService};