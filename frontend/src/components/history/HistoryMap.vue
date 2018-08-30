<template>
    <section id="map">
        <mapbox
            :access-token="mapboxToken"
            :map-options="{
                style: mapboxStyle,
            }"
            :fullscreen-control="{
                show: true,
                position: 'bottom-right'
            }"
            @map-init="mapInitialize"
        />
    </section>
</template>

<script>
import {mapGetters, mapActions, mapState} from 'vuex';
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
            isPlacesLoaded: false,
            isMapLoaded: false,
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
            'mapInitialized',
        ]),
    },

    created() {
        this.$store.dispatch('history/setLoadingState', true);
        this.loadUserCoords().then((coords) => {
            this.setCurrentMapCenter(coords);
        });

        this.loadCheckInPlaces()
            .then(() => {
                this.isPlacesLoaded = true;
                this.setCurrentMapCenter(
                    mapSettingsService.getMapboxCenter(
                        this.places.byId,
                        this.places.allIds
                    )
                );
            })
            .catch((err) => {
                this.isPlacesLoaded = false;
            });
    },

    watch: {
        isMapLoaded: function (oldVal, newVal) {
            this.updateMap(this.placeList);
        },

        isPlacesLoaded: function (oldVal, newVal) {
            this.updateMap(this.placeList);
        }
    },

    methods: {
        ...mapActions('history', [
            'loadCheckInPlaces',
            'setCurrentMapCenter',
            'mapInitialization',
            'setLoadingState'
        ]),

        mapInitialize(map) {
            this.markerManager = markerManager.getService(map);
            this.isMapLoaded = true;
        },

        updateMap(places) {
            if (this.isMapLoaded && this.isPlacesLoaded) {
                this.markerManager.setMarkersFromPlacesAndFit(...places);
            }
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
        }
    }
};
</script>

<style lang="scss" scoped>

</style>
