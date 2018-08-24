<template>
    <mapbox
        :access-token="getMapboxToken"
        :map-options="{
            style: getMapboxStyle,
            center: currentCenter,
            zoom: 11
        }"
        :scale-control="{
            show: true,
            position: 'top-left'
        }"
        @map-init="mapInitialize"
        @map-load="mapLoaded"
    />
</template>

<script>
import { mapGetters, mapActions } from 'vuex';
import Mapbox from 'mapbox-gl-vue';
import markerManager from '@/services/map/markerManager';

export default {
    name: 'PlaceMapMarker',

    data() {
        return {
            isMapLoaded: false,
            map: {},
            markerManager: null,
        };
    },

    props: {
        place: {
            type: Object,
            required: true
        }
    },

    components: {
        Mapbox
    },

    created() {
        if (this.isMapLoaded) {
            this.updateMap();
            markerManager.fitMarkersOnMap();
        }
    },

    methods: {
        ...mapActions('place', ['mapInitialization']),

        mapInitialize(map) {
            if (this.mapInitialized) {
                return;
            }
            this.map = map;
            this.mapInitialization();
        },

        mapLoaded(map) {
            this.markerManager = markerManager.getService(map);
            this.isMapLoaded = true;
        },

        updateMap() {
            if (this.isMapLoaded) {
                this.markerManager.setMarkersFromPlacesAndFit(this.place);
            }
        }
    },

    watch: {
        isMapLoaded: function (oldVal, newVal) {
            this.updateMap();
        },
    },

    computed: {
        ...mapGetters('map', [
            'getMapboxToken',
            'getMapboxStyle'
        ]),

        currentCenter() {
            return {
                lat: this.place.latitude,
                lng: this.place.longitude
            };
        }
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
</style>

<style lang="scss" scoped>
    #map {
        text-align: justify;
        position: sticky;
        position: -webkit-sticky;
        top: 0;
        height: 200px;
        right: 0;
        width: 100%;
    }
</style>
