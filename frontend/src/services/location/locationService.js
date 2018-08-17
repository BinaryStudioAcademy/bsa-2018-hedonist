import VueGeolocation from 'vue-browser-geolocation';
import httpService from '../common/httpService';

export class LocationService {

    getUserLocationData(){
        return VueGeolocation.getLocation({
            enableHighAccuracy: true,
        });
    }

    getCityList(mapboxToken, citySearchQuery){
        return new Promise((resolve, reject) => {
            if(!citySearchQuery){
                reject('empty query');
            }else{
                let mapboxCitiesApiUrl = `https://api.mapbox.com/geocoding/v5/mapbox.places/${citySearchQuery}.json?access_token=${mapboxToken}&country=ua&autocomplete=true&language=en`;

                httpService.get(mapboxCitiesApiUrl)
                    .then(({ data }) => {
                        resolve(data.features);
                    })
                    .catch(function (err) {
                        reject(err);
                    });
            }
        });
    }

}

export default new LocationService();
