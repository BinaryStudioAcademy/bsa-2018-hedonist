<template>
    <section id="map">
        <mapbox
            :access-token="mapboxToken"
            :map-options="{
                style: mapboxStyle,
                center: {
                    lat: 48.26,
                    lng: 31.31
                },
                zoom: 4.7
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
            'mapInitialized',
        ]),
    },

    created() {
        if (this.placeList.length < 1) {
            this.setLoadingState(true);
        }

        this.loadCheckInPlaces()
            .then(() => {
                this.isPlacesLoaded = true;
                this.setLoadingState(false);
            })
            .catch((err) => {
                this.setLoadingState(false);
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
            'mapInitialization',
            'setLoadingState'
        ]),

        mapInitialize(map) {
            this.markerManager = markerManager.getService(map);
            this.isMapLoaded = true;
        },

        updateMap(places) {
            if (this.isMapLoaded && places.length > 1) {
                this.markerManager.setMarkersFromPlacesAndFit(...places);
            }
        },
    }
};
</script>

<style lang="scss" scoped>

</style>
