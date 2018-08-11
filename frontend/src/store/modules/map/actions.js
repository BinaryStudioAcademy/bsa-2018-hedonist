
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
    }
}