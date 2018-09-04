import VueGeolocation from 'vue-browser-geolocation';
import httpService from '../common/httpService';
import mapSettingsService from '../map/mapSettingsService';

export class LocationService {

    getUserLocationData(){
        return VueGeolocation.getLocation({
            enableHighAccuracy: true,
        });
    }

    getCityList(params) {
        return new Promise((resolve, reject) => {
            if(!params){
                reject(new Error('empty query'));
            }else{
                let mapboxCitiesApiUrl = mapSettingsService.getMapboxCitiesApiUrl(mapSettingsService.getMapboxToken(), params);
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
