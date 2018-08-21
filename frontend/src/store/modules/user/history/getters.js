export default {
    getCheckInById: state => id => {
        return state.checkIns.byId[id];
    },

    getPlaceById: state => id => {
        return state.places.byId[id];
    },

    getPlaceByCheckInId: state => id => {
        let placeId = state.checkIns.byId[id].placeId;
        return state.places.byId[placeId];
    },

    getMapboxCenter: () => (placeItems, placeIds) => {
        const totalLongitude = _.sumBy(placeIds, (id) => placeItems[id].longitude);
        const totalLatitude = _.sumBy(placeIds, (id) => placeItems[id].latitude);
        const count = placeIds.length;

        return {
            longitude: (totalLongitude / count),
            latitude: (totalLatitude / count)
        };
    },

    placeList: (state) => {
        let placeArray = [];
        for (let id of state.places.allIds) {
            placeArray.push(state.places.byId[id]);
        }

        return placeArray;
    }
};
