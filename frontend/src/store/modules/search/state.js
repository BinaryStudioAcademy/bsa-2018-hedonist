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
    place: '',
    page: 1,
    location: null,
    currentPosition: {
        latitude: KIEV_LATITUDE,
        longitude: KIEV_LONGITUDE
    },
    locationAvailable: false,
    mapInitialized : false,
    filters: {
        checkin: false,
        saved: false,
        top_rated: false,
        top_reviewed: false,
        recommended: false
    },
    selectedTags: [],
    isLoading: false
};