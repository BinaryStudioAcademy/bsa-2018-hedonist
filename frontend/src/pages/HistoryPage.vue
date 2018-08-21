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

        <div v-if="mapInitialized" class="column mapbox-wrapper">
            <section id="map">
                <mapbox
                    :access-token="getMapboxToken"
                    :map-options="{
                        style: getMapboxStyle,
                        center: {
                            lat: currentLatitude,
                            lng: currentLongitude
                        },
                        zoom: 12
                    }"
                    :fullscreen-control="{
                        show: true,
                        position: 'bottom-right'
                    }"
                    :scale-control="{
                        show: true,
                        position: 'top-left'
                    }"
                    @map-init="mapInitialize"
                />
            </section>
        </div>
    </div>
</template>

<script>
import { mapGetters, mapActions, mapState } from 'vuex';
import PlaceVisitedPreview from '../components/place/PlaceVisitedPreview';
import LocationService from '@/services/location/locationService';
import MarkerService from '@/services/map/markerManagerService';
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
            markerManager: null,
            userCoordinates: {
                lat: null,
                lng: null
            },
        };
    },
    computed: {
        ...mapGetters('map', ['getMapboxToken', 'getMapboxStyle']),
        ...mapGetters('user/history', [
            'getCheckInById',
            'getMapboxCenter',
            'getPlaceById',
            'getPlaceByCheckInId',
            'placeList'
        ]),
        ...mapState('user/history', [
            'checkIns', 'places', 'currentLatitude', 'currentLongitude', 'mapInitialized'
        ]),
    },
    created() {
        this.loadUserCoords()
            .then((coords) => {
                this.setCurrentMapCenter(coords);
                this.mapInitialization();
            })
            .then(() => {
                this.loadCheckInPlaces()
                    .then(() => {
                        this.isPlacesLoaded = true;
                        this.setCurrentMapCenter(
                            this.getMapboxCenter(this.places.byId, this.places.allIds)
                        );
                        this.updateMap(this.placeList);
                        this.markerManager.fitMarkersOnMap();
                    })
                    .catch((err) => {
                        this.isPlacesLoaded = true;
                    });
            });
    },
    methods: {
        ...mapActions('user/history', [
            'loadCheckInPlaces', 'setCurrentMapCenter', 'mapInitialization'
        ]),

        mapInitialize(map) {
            this.markerManager = new MarkerService(map);
        },
        updateMap(places) {
            this.markerManager.setMarkers(places);
        },
        loadUserCoords() {
            return new Promise((resolve, reject) => {
                LocationService.getUserLocationData()
                    .then(coordinates => {
                        this.userCoordinates.lat = coordinates.lat;
                        this.userCoordinates.lng = coordinates.lng;
                        resolve({
                            latitude: coordinates.lat,
                            longitude: coordinates.lng
                        });
                    });
            });
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
