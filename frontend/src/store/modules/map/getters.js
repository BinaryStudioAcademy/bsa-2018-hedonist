export default {
    getMapboxStyle: function() {
        return process.env.MAPBOX_STYLE;
    },
    getMapboxToken: function() {
        return process.env.MAPBOX_TOKEN;
    },
    getMapboxCenter: () => (places) => {
        let totalLongitude = _.sumBy(places.allIds, (id) => places.byId[id].longitude);
        let totalLatitude = _.sumBy(places.allIds, (id) => places.byId[id].latitude);
        let count = places.allIds.length;

        return [ (totalLongitude / count), (totalLatitude / count) ];
    }
};