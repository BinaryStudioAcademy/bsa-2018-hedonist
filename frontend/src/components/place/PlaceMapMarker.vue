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
        @map-load="mapLoaded"
    />
</template>

<script>
import { mapGetters, mapActions } from 'vuex';
import Mapbox from 'mapbox-gl-vue';
import markerManager from '@/services/map/markerManager';

export default {
    name: 'PlaceMapMarker',

    props: {
        place: {
            type: Object,
            required: true
        }
    },

    components: {
        Mapbox
    },

    methods: {
        mapLoaded(map) {
            markerManager.getService(map).setMarkersFromPlacesAndFit(this.place);
        }
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
