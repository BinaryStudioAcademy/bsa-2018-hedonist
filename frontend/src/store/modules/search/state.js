import { KIEV_LATITUDE, KIEV_LONGITUDE } from '@/services/location/positions';

export default {
    city: {
        name: '',
        longitude: null,
        latitude: null,
        fullName: ''
    },
    placeCategory: {
        id: null,
        name: ''
    },
    place: {
        id: null,
        name: ''
    },
    page: 1,
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