import httpService from '@/services/common/httpService';
import router from '@/router';

export default {
    selectSearchCity: ({commit}, city) => {
        commit('SET_SEARCH_CITY', city);
    },

    selectSearchPlaceCategory: ({commit}, category) => {
        commit('SET_SEARCH_PLACE_CATEGORY', category);
    },

    loadCategories(context, name) {
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
    }
};