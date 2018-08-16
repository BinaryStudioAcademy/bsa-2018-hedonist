<template>
    <div class="row">
        <div v-if="isPlacesLoaded" class="column visitedplaces-wrapper">
            <div 
                v-for="(visitedPlace,index) in visitedPlaces" 
                :key="visitedPlace.id"
            >
                <PlaceVisitedPreview 
                    :visited-place="visitedPlace"
                    :timer="50 * (index+1)"
                />
            </div>
        </div>

        <div v-if="isPlacesLoaded" class="column mapbox-wrapper">
            <section id="map">
                <mapbox
                    @map-load="mapLoaded"
                    :access-token="getMapboxToken"
                    :map-options="{
                        style: getMapboxStyle,
                        center: getMapboxCenter(),
                        zoom: 0
                    }"
                    :fullscreen-control="{
                        show: true,
                        position: 'bottom-right'
                    }"
                />
            </section>
        </div>
    </div>
</template>

<script>
import { mapGetters } from 'vuex';
import PlaceVisitedPreview from '../components/place/PlaceVisitedPreview';
import Mapbox from 'mapbox-gl-vue';
import mapActions from '../store/modules/map/actions';

export default {
    name: 'HistoryPage',
    components: {
        PlaceVisitedPreview,
        Mapbox
    },
    data() {
        return {
            visitedPlaces: null,
            isPlacesLoaded: false,
        }
    },
    computed: {
        ...mapGetters('map', ['getMapboxToken', 'getMapboxStyle'])
    },
    created() {
        this.$store.dispatch('place/loadCheckInPlaces')
            .then((response) => {
                this.visitedPlaces = response;
                this.isPlacesLoaded = true;
            })
            .catch((err) => {
                this.isPlacesLoaded = true;
            });
    },
    methods: {
        mapLoaded: function (map) {
            map.addLayer({
                'id': 'points',
                'type': 'symbol',
                'source': {
                    'type': 'geojson',
                    'data': {
                        'type': 'FeatureCollection',
                        'features': this.generateMapFeatures()
                    }
                },
                'layout': {
                    'icon-image': '{icon}-15',
                    'text-field': '{title}',
                    'text-font': ['Open Sans Semibold', 'Arial Unicode MS Bold'],
                    'text-offset': [0, 0.6],
                    'text-anchor': 'top'
                }
            });
        },
        generateMapFeatures: function () {
            let features = [];
            this.visitedPlaces.forEach(function (place, i) {

                let feature = {
                    'type' : 'Feature',
                    'geometry' : {
                        'type' : 'Point',
                        'coordinates' : [place.place.longitude, place.place.latitude]
                    },
                    'properties' : {
                        'title' : place.place.placeName,
                        'icon' : 'marker',
                        'marker-symbol' : i + 1
                    }
                };

                features.push(feature);
            });

            return features;
        },
        getMapboxCenter: function() {
            return mapActions.getMapboxCenter(this.visitedPlaces);
        }
    }
};

</script>

<style lang="scss" scoped>

    .mapboxgl-ctrl-top-left,
    .mapboxgl-ctrl-top-right {
        top: 50px;
    }

    .row {
        display: flex;
    }

    .column {
        flex: 50%;
    }

    #map {
        text-align: justify;
        position: fixed;
        top: 0;
        bottom: 0;
        right: 0;
        width: 50%;
    }

    @media screen and (max-width: 769px) {
        #map {
            text-align: justify;
            vertical-align: top;
            position: relative;
            top: 0;
            left: 0;
            width: 100%;
            height: 500px;
        }
    }
</style>