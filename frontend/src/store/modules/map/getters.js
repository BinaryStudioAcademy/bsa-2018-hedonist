export default {
    getMapboxStyle: function() {
        return process.env.MAPBOX_STYLE;
    },
    getMapboxToken: function() {
        return process.env.MAPBOX_TOKEN;
    },
    getMapboxCenter: () => (placeItems, placeIds) => {
        let totalLongitude = _.sumBy(placeIds, (id) => placeItems[id].longitude);
        let totalLatitude = _.sumBy(placeIds, (id) => placeItems[id].latitude);
        let count = placeIds.length;

        return [ (totalLongitude / count), (totalLatitude / count) ];
    }
};