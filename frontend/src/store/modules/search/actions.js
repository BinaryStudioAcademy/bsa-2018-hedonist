import httpService from '@/services/common/httpService';

export default {
    selectSearchCity: ({commit}, city) => {
        commit('SET_SEARCH_CITY', city);
    },

    selectSearchPlaceCategory: ({commit}, category) => {
        commit('SET_SEARCH_PLACE_CATEGORY', category);
    },

    loadCategories(context, name) {
        return httpService.post('/places/categories/search', {'name': name})
            .then( result => Promise.resolve(result.data.data))
            .catch( error  => Promise.reject(error));
    },

    setCurrentCenter: ({ commit }, currentCenter) => {
        commit('SET_CURRENT_CENTER', currentCenter);
    },

    mapInitialization: ({ commit }) => {
        commit('MAP_INIT', true);
    }
};