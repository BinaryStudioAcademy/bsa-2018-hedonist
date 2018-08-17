<template>
    <div class="row">
        <div v-if="isPlacesLoaded" class="column visitedplaces-wrapper">
            <div 
                v-for="(checkIn, index) in checkIns"
                :key="checkIn.id"
            >
                <PlaceVisitedPreview 
                    :check-in="checkIn"
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
                        center: getMapboxCenter(checkIns),
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
import { mapGetters, mapActions, mapState } from 'vuex';
import PlaceVisitedPreview from '../components/place/PlaceVisitedPreview';
import Mapbox from 'mapbox-gl-vue';

export default {
    name: 'HistoryPage',
    components: {
        PlaceVisitedPreview,
        Mapbox
    },
    data() {
        return {
            isPlacesLoaded: false,
        };
    },
    computed: {
        ...mapGetters('map', ['getMapboxToken', 'getMapboxStyle', 'getMapboxCenter']),
        ...mapState('place', ['checkIns'])
    },
    created() {
        this.loadCheckInPlaces()
            .then(() => {
                this.isPlacesLoaded = true;
            })
            .catch((err) => {
                this.isPlacesLoaded = true;
            });
    },
    methods: {
        ...mapActions('place', ['loadCheckInPlaces']),
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
            this.checkIns.forEach(function (checkIn, i) {

                let feature = {
                    'type' : 'Feature',
                    'geometry' : {
                        'type' : 'Point',
                        'coordinates' : [checkIn.place.longitude, checkIn.place.latitude]
                    },
                    'properties' : {
                        'title' : checkIn.place.placeName,
                        'icon' : 'marker',
                        'marker-symbol' : i + 1
                    }
                };

                features.push(feature);
            });

            return features;
        },
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
        .row {
            display: grid;
            grid-template-areas: "right" "left";

            .visitedplaces-wrapper {
                grid-area: left;
            }
            .mapbox-wrapper {
                grid-area: right;
                position: relative;
                height: 500px;

                #map {
                    position: absolute;
                    width: 100%;
                }
            }
        }
        .column {
            flex: 100%;
        }
    }

    @media screen and (max-width: 520px) {
        .row {
            .mapbox-wrapper {
                height: 300px;
            }
        }
    }
</style>
