<template>
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
</template>

<script>
import { mapGetters, mapActions, mapState } from 'vuex';
import Mapbox from 'mapbox-gl-vue';
import LocationService from '@/services/location/locationService';
import markerManager from '@/services/map/markerManager';
import mapSettingsService from '@/services/map/mapSettingsService';

export default {
    name: 'HistoryMap',

    components: {
        Mapbox
    },

    data() {
        return {
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
        ...mapGetters('history', [
            'getPlaceById',
            'placeList'
        ]),

        ...mapState('history', [
            'places',
            'currentLatitude',
            'currentLongitude',
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
                        this.setCurrentMapCenter(
                            mapSettingsService.getMapboxCenter(
                                this.places.byId,
                                this.places.allIds
                            )
                        );
                        this.updateMap(this.placeList);
                    });
            });
    },

    methods: {
        ...mapActions('history', [
            'loadCheckInPlaces',
            'setCurrentMapCenter',
            'mapInitialization',
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

<style lang="scss" scoped>
    #map {
        text-align: justify;
        position: fixed;
        top: 87px;
        bottom: 0;
        right: 0;
        width: 50%;

        @media screen and (max-width: 769px) {
            position: absolute;
            width: 100%;
        }
    }
</style>
