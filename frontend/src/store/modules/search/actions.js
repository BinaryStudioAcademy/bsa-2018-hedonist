export default {
    selectSearchCity: ({commit}, city) => {
        commit('SET_SEARCH_CITY', city);
    },
    setCurrentCenter: ({ commit }, currentCenter) => {
        commit('SET_CURRENT_CENTER', currentCenter);
    },
    mapInitialization: ({ commit }) => {
        commit('MAP_INIT', true);
    }
};