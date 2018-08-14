let parser = (item) => ({
    name: item.name,
    longitude: item.longitude,
    latitude: item.latitude
});

export default {
    getUserLocationData(){

    },

    setParser(newParser) {
        parser = newParser;
        return this;
    },

    encodeGeoJson(...objects) {
        let data = {type: 'FeatureCollection'};
        data.features = objects.map(function (item) {
            let parsed = parser(item);
            return {
                type: "Feature",
                geometry: {
                    type: "Point",
                    coordinates: [parsed.latitude, parsed.longitude],
                    properties: {
                        title: parsed.name,
                    }
                }
            };
        });
        return data;
    },
}