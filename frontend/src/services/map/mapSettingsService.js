export default {
    getMapboxStyle: function() {
        return process.env.MAPBOX_STYLE;
    },
    getMapboxToken: function() {
        return process.env.MAPBOX_TOKEN;
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
    getMapboxCitiesApiUrl: (mapboxToken, params) => {
        return `${apiUrl}${params}.json?access_token=${mapboxToken}&country=ua&types=place&autocomplete=true&language=en`;
    }
};

const apiUrl = 'https://api.mapbox.com/geocoding/v5/mapbox.places/';