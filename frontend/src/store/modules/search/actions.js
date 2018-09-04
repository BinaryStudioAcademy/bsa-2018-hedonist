import httpService from '@/services/common/httpService';
import router from '@/router';
import LocationService from '@/services/location/locationService';
import mapSettingsService from '@/services/map/mapSettingsService';
import { KIEV_LATITUDE, KIEV_LONGITUDE } from '@/services/location/positions';

export default {
    updateStateFromQuery: ({commit, dispatch}, query) => {
        if(query.name) commit('SET_SEARCH_PLACE', {name: query.name});
        if(query.page) commit('SET_PAGE', query.page);
        if(query.category) commit('SET_SEARCH_PLACE_CATEGORY', {id: query.category, name: ''});
        if(query.location) {
            let location = query.location.split(',');
            commit('SET_SEARCH_CITY', {center: location});
            commit('SET_CURRENT_POSITION', {
                latitude: location[1],
                longitude: location[0]
            });
        } else {
            return LocationService.getUserLocationData()
                .then(coordinates => {
                    let city = {center: [coordinates.lng, coordinates.lat]};
                    commit('SET_SEARCH_CITY', city);
                    commit('SET_CURRENT_POSITION', {
                        latitude: coordinates.lat,
                        longitude: coordinates.lng
                    });
                })
                .catch(() => {
                    dispatch('setLocationAvailable', false);
                    let city = {center: [KIEV_LONGITUDE, KIEV_LATITUDE]};
                    commit('SET_SEARCH_CITY', city);
                });
        }
        return Promise.resolve();
    },
    selectSearchCity: ({commit}, city) => {
        commit('SET_SEARCH_CITY', city);
    },

    selectSearchCategory: ({commit}, item) => {
        commit('SET_SEARCH_PLACE_CATEGORY', item);
        commit('DELETE_SEARCH_PLACE');
    },

    selectSearchPlace: ({commit}, searchPlace) => {
        commit('SET_SEARCH_PLACE', searchPlace);
        commit('DELETE_SEARCH_PLACE_CATEGORY');
    },

    loadCategories({context , commit}, name) {
        return httpService.get('/places/categories/search?name=' + name + '&limit=')
            .then(result => Promise.resolve(result.data.data))
            .catch(error => Promise.reject(error));
    },

    updateQueryFilters({state, dispatch}) {
        let location = state.currentPosition.longitude + ',' + state.currentPosition.latitude;
        if (state.city.longitude && state.city.latitude) {
            location = state.city.longitude + ',' + state.city.latitude;
        }
        let query = {
            category: state.placeCategory && state.placeCategory.id,
            page: state.page,
            name: state.place,
            location: location,
            ...state.filters
        };
        Object.keys(query).map((param) => { //convert bool to int, remove empty
            if (query[param] === true) {
                query[param] = 1;
            }
            if (!query[param]) {
                delete query[param];
            }
        });

        router.push({
            name: 'SearchPlacePage',
            query
        });

        dispatch('setLoadingState', true);
        dispatch('place/fetchPlaces', query, {root:true}).then(() => {
            dispatch('setLoadingState', false);
        });
    },

    setCurrentPosition: ({commit}, currentPosition) => {
        commit('SET_CURRENT_POSITION', currentPosition);
    },

    setLocationAvailable: ({commit}, locationAvailable) => {
        commit('SET_LOCATION_AVAILABLE', locationAvailable);
    },

    setLoadingState: ({commit}, isLoading) => {
        commit('SET_LOADING_STATE', isLoading);
    },

    setFilters: ({commit, dispatch}, filters) => {
        commit('SET_FILTERS', filters);
        dispatch('updateQueryFilters');
    },

    initFilters: ({commit}) => {
        let query = router.currentRoute.query;
        let filters = {
            checkin: !!query['checkin'],
            saved: !!query['saved'],
            top_rated: !!query['top_rated'],
            top_reviewed: !!query['top_reviewed'],
        };

        commit('SET_FILTERS', filters);
    },

    mapInitialization: ({commit}) => {
        commit('MAP_INIT', true);
    },

    loadPlaces(context, filters) {
        return httpService.get('/places/autocomplete/search?filter[name]=' + filters.name + '&filter[location]=' + filters.location)
            .then( result => Promise.resolve(result.data.data))
            .catch( error  => Promise.reject(error));
    }
};