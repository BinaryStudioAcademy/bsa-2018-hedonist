export default {
    getMapboxStyle: function() {
        return process.env.MAPBOX_STYLE;
    },
    getMapboxToken: function() {
        return process.env.MAPBOX_TOKEN;
    },
    getMapboxCenter: () => (checkIns) => {
        let totalLongtitude = 0;
        let totalLatitude = 0;
        let count = checkIns.length;

        checkIns.forEach(function (checkIn) {
            totalLongtitude += parseFloat(checkIn.place.longitude);
            totalLatitude += parseFloat(checkIn.place.latitude);
        });

        return [totalLongtitude/count, totalLatitude/count];
    }
};