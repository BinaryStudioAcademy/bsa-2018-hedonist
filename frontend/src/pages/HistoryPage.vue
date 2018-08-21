<template>
    <div class="row">
        <div v-if="isPlacesLoaded" class="column visitedplaces-wrapper">
            <div
                v-for="(checkInId, index) in checkIns.allIds"
                :key="checkInId"
            >
                <PlaceVisitedPreview
                    :check-in="getCheckInById(checkInId)"
                    :check-in-place="getPlaceByCheckInId(checkInId)"
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
                        center: getMapboxCenter(places.byId, places.allIds),
                        zoom: 15
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
        ...mapGetters('user/history', ['getCheckInById']),
        ...mapGetters('user/history', ['getPlaceById']),
        ...mapGetters('user/history', ['getPlaceByCheckInId']),
        ...mapState('user/history', ['checkIns']),
        ...mapState('user/history', ['places']),
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
        ...mapActions('user/history', ['loadCheckInPlaces']),

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
            this.places.allIds.forEach((id, i) => {
                const place = this.getPlaceById(id);
                const feature = {
                    'type' : 'Feature',
                    'geometry' : {
                        'type' : 'Point',
                        'coordinates' : [place.longitude, place.latitude]
                    },
                    'properties' : {
                        'title' : place.name,
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
