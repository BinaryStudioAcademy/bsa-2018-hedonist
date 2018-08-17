import httpService from "../../../services/common/httpService";

export default {
    selectSearchCity: ({commit}, city) => {
        commit('SET_SEARCH_CITY', city);
    },
    getCityList: (context, citySearchQuery) => {
        return new Promise((resolve, reject) => {
            let mapboxCitiesApiUrl = `https://api.mapbox.com/geocoding/v5/mapbox.places/${citySearchQuery}.json?access_token=${context.rootGetters['map/getMapboxToken']}&country=ua&autocomplete=true&language=en`;

            httpService.get(mapboxCitiesApiUrl)
                .then(({ data }) => {
                    resolve(data.features);
                })
                .catch(function (err) {
                    reject(err);
                });
        });
    },

};