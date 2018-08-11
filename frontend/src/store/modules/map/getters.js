export default {
    getMapboxStyle: function() {
        return process.env.MAPBOX_STYLE
    },
    getMapboxToken: function() {
        return process.env.MAPBOX_TOKEN;
    }
}