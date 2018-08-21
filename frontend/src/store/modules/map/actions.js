export default {
    getMapboxCenter: function(places) {
        let totalLongtitude = 0;
        let totalLatitude = 0;
        let count = places.length;

        places.forEach(function (place) {
            totalLongtitude += parseFloat(place.longitude);
            totalLatitude += parseFloat(place.latitude);
        });

        return [totalLongtitude/count, totalLatitude/count];
    },
    setCurrentCenter: ({ commit }, currentCenter) => {
        commit('SET_CURRENT_CENTER', currentCenter);
    },
    mapInitialization: ({ commit }) => {
        commit('MAP_INIT', true);
    }
};