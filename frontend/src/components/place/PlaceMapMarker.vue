<template>
    <mapbox
        :access-token="mapboxToken"
        :map-options="{
            style: mapboxStyle,
            center: currentCenter,
            zoom: 12
        }"
        @map-load="mapLoaded"
    />
</template>

<script>
import Mapbox from 'mapbox-gl-vue';
import markerManager from '@/services/map/markerManager';
import mapSettingsService from '@/services/map/mapSettingsService';

export default {
    name: 'PlaceMapMarker',

    props: {
        place: {
            type: Object,
            required: true
        }
    },

    data() {
        return {
            mapboxToken: mapSettingsService.getMapboxToken(),
            mapboxStyle: mapSettingsService.getMapboxStyle()
        };
    },

    components: {
        Mapbox
    },

    methods: {
        mapLoaded(map) {
            markerManager.getService(map).setConcretePlaceMarker(this.place);
        }
    },

    computed: {
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
