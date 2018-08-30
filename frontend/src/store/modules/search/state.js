import { KIEV_LATITUDE, KIEV_LONGITUDE } from '@/services/location/positions';

export default {
    city: null,
    placeCategory: null,
    place: null,
    currentPosition: {
        latitude: KIEV_LATITUDE,
        longitude: KIEV_LONGITUDE
    },
    mapInitialized : false,
    filters: {
        checkin: false,
        saved: false,
        top_rated: false,
        top_reviewed: false
    },
    isLoading : false
};