import httpService from '@/services/common/httpService';
import router from '@/router';
import LocationService from '@/services/location/locationService';
import mapSettingsService from '@/services/map/mapSettingsService';

export default {
    selectSearchCity: ({commit}, city) => {
        if (city !== null) {
            commit('SET_SEARCH_CITY', city);
        } else {
            commit('DELETE_SEARCH_CITY');
        }
    },

    selectSearchPlaceOrCategory: ({commit}, item) => {
        if (item !== null) {
            if (item.place !== undefined) {
                commit('SET_SEARCH_PLACE', item);

                LocationService.getCityList(mapSettingsService.getMapboxToken(), item.city.name)
                    .then( res => {
                        if (res.length > 0) {
                            commit('SET_SEARCH_CITY', res[0]);
                        } else {
                            commit('DELETE_SEARCH_CITY');
                        }
                    });
                commit('DELETE_SEARCH_PLACE_CATEGORY');
            } else {
                commit('SET_SEARCH_PLACE_CATEGORY', item);
                commit('DELETE_SEARCH_PLACE');
            }
        } else {
            commit('DELETE_SEARCH_PLACE');
            commit('DELETE_SEARCH_PLACE_CATEGORY');
        }

    },

    loadCategories({context , commit}, name) {
        return httpService.get('/places/categories/search?name=' + name + '&limit=')
            .then(result => Promise.resolve(result.data.data))
            .catch(error => Promise.reject(error));
    },

    updateQueryFilters({state}) {
        let query = {
            category: state.placeCategory && state.placeCategory.id,
            location:
                state.city.longitude &&
                state.city.latitude &&
                (state.city.longitude + ',' + state.city.latitude),
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
    },

    setCurrentPosition: ({commit}, currentPosition) => {
        commit('SET_CURRENT_POSITION', currentPosition);
    },

    setFilters: ({commit, dispatch}, filters) => {
        commit('SET_FILTERS', filters);
        dispatch('updateQueryFilters');
    },

    initFilters: ({dispatch}) => {
        let query = router.currentRoute.query;
        let filters = {
            checkin: !!query['checkin'],
            saved: !!query['saved'],
            top_rated: !!query['top_rated'],
            top_reviewed: !!query['top_reviewed'],
        };

        dispatch('setFilters', filters);
    },

    mapInitialization: ({commit}) => {
        commit('MAP_INIT', true);
    },

    loadPlaces(context, filters) {
        return httpService.get('/places/autocomplete/search?filter[name]=' + filters.name + '&filter[location]=' + filters.location)
            .then( result => Promise.resolve(result.data.data))
            .catch( error  => Promise.reject(error));
    },
};