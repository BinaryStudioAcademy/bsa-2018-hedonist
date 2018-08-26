<template>
    <section class="columns">
        <section v-if="isPlacesLoaded" class="column is-half">
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
        </section>

        <section v-if="mapInitialized" class="column mapbox-wrapper right-side">
            <section id="map">
                <mapbox
                    :access-token="mapboxToken"
                    :map-options="{
                        style: mapboxStyle,
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
        </section>
    </section>
</template>

<script>
import {mapGetters, mapActions, mapState} from 'vuex';
import PlaceVisitedPreview from '../components/place/PlaceVisitedPreview';
import LocationService from '@/services/location/locationService';
import markerManager from '@/services/map/markerManager';
import Mapbox from 'mapbox-gl-vue';
import mapSettingsService from '@/services/map/mapSettingsService';

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
            mapboxToken: mapSettingsService.getMapboxToken(),
            mapboxStyle: mapSettingsService.getMapboxStyle()
        };
    },
    computed: {
        ...mapGetters('user/history', [
            'getCheckInById',
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
                            mapSettingsService.getMapboxCenter(this.places.byId, this.places.allIds)
                        );
                        this.updateMap(this.placeList);
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
            this.markerManager = markerManager.getService(map);
        },
        updateMap(places) {
            this.markerManager.setMarkersFromPlacesAndFit(...places);
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

<style>
    .mapboxgl-canvas {
        top: 0 !important;
        left: 0 !important;
    }

    .mapboxgl-marker {
        cursor: pointer;
    }

    .mapboxgl-popup-close-button{
        font-size: 22px;
    }

    .link-place:hover{
        text-decoration: underline;
    }
</style>

<style lang="scss" scoped>

    .columns {
        padding: 10px;
    }

    #map {
        text-align: justify;
        position: sticky;
        position: -webkit-sticky;
        top: 3.75rem;
        height: 100vh;
        right: 0;
        width: 100%;
    }

    @media screen and (max-width: 769px) {
        .columns {
            display: grid;
            grid-template-areas: "right" "left";

            .is-half {
                grid-area: left;
            }
            .right-side {
                grid-area: right;
            }
        }
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

    @media screen and (max-width: 520px) {
        #map {
            height: 300px;
        }
    }
</style>
