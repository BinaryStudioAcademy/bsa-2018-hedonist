import VueGeolocation from 'vue-browser-geolocation';

export class LocationService {

    getUserLocationData(){
        return VueGeolocation.getLocation({
            enableHighAccuracy: true,
        });
    }

}

export default new LocationService();