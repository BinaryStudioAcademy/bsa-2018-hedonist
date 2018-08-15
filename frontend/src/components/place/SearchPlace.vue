<template>
    <section class="columns">
        <section class="column is-half">
            <b-input 
                class="search-field" 
                placeholder="Find..." 
                v-model="filterQuery"
            />
            <template v-for="(place, index) in filteredPlaces">
                <PlaceListComponent 
                    :key="place.id" 
                    :place="place" 
                    :timer="50 * (index+1)"
                />
            </template>
        </section>

        <section class="column mapbox-wrapper">
            <section id="map">
                <mapbox
                        @map-load="initMap"
                        :access-token="getMapboxToken"
                        :map-options="{
                        style: getMapboxStyle,
                        zoom: 3,
                    }"
                        :scale-control="{
                        show: true,
                        position: 'top-left'
                    }"
                        :fullscreen-control="{
                        show: true,
                        position: 'top-left'
                    }"
                />
            </section>
        </section>
    </section>
</template>

<script>
import { mapState } from 'vuex';
import { mapGetters } from 'vuex';
import PlaceListComponent from '@/components/placesList/PlaceListComponent';
import Mapbox from 'mapbox-gl-vue';

let markerManager = null;

export default {
    name: 'SearchPlace',
    components: {
        PlaceListComponent,
        Mapbox,
    },
    data() {
        return {
            filterQuery: '',
            mapLoaded: false
        };
    },
    methods: {
        initMap(map) {
            markerManager = new MarkerService(map);
            this.mapLoaded = true;
        },
        updateMap(places){
            markerManager.setMarkers(...places);
        },
    },
    computed: {
        ...mapState('place', ['places']),
        ...mapGetters('place', ['getFilteredByName']),
        ...mapGetters('map', ['getMapboxToken', 'getMapboxStyle']),
        filteredPlaces: function() {
            let places = [];
            if (this.filterQuery) {
                places = this.getFilteredByName(this.filterQuery);
            } else {
                places = this.places;
            }
            if(this.mapLoaded){
                this.updateMap(places);
            }

            return places;
        }
    }
};
</script>

<style>
    .mapboxgl-canvas {
        top: 0 !important;
        left: 0 !important;
    }
</style>

<style scoped>
    .search-field {
        margin-bottom: 10px;
    }

    .columns {
        padding-left: 10px;
        padding-right: 10px;
    }

    #map {
        text-align: justify;
        position: fixed;
        top: 52px;
        bottom: 0;
        right: 0;
        width: 50%;
    }

    @media screen and (max-width: 769px) {
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
</style>