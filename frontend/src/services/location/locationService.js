import VueGeolocation from 'vue-browser-geolocation';
import httpService from '../common/httpService';

export class LocationService {

    getUserLocationData(){
        return VueGeolocation.getLocation({
            enableHighAccuracy: true,
        });
    }

    getCityList(mapboxCitiesApiUrl) {
        return new Promise((resolve, reject) => {
            if(!mapboxCitiesApiUrl){
                reject(new Error('empty query'));
            }else{
                httpService.get(mapboxCitiesApiUrl)
                    .then(({ data }) => {
                        resolve(data.features);
                    })
                    .catch(({ err }) => {
                        reject(err);
                    });
            }
        });
    }
}

export default new LocationService();
