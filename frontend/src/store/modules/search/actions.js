import httpService from '@/services/common/httpService';

export default {
    selectSearchCity: ({commit}, city) => {
        commit('SET_SEARCH_CITY', city);
    },

    selectSearchPlaceCategory: ({commit}, category) => {
        commit('SET_SEARCH_PLACE_CATEGORY', category);
    },

    loadCategories({context , commit}, name) {
        return httpService.get('/places/categories/search?name=' + name + '&limit=')
            .then( result => Promise.resolve(result.data.data))
            .catch( error  => Promise.reject(error));
    },

    setCurrentPosition: ({ commit }, currentPosition) => {
        commit('SET_CURRENT_POSITION', currentPosition);
    },

    mapInitialization: ({ commit }) => {
        commit('MAP_INIT', true);
    }
};