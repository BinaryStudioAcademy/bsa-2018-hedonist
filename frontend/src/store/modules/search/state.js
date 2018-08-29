import { KIEV_LATITUDE, KIEV_LONGITUDE } from '@/services/location/positions';

export default {
    city: {
        name: '',
        longitude: 0,
        latitude: 0,
        fullName: ''
    },
    placeCategory: {
        id: null,
        name: ''
    },
    currentPosition: {
        latitude: KIEV_LATITUDE,
        longitude: KIEV_LONGITUDE
    },
    mapInitialized : false,
    isLoading : false
};