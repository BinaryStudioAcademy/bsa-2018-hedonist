<template>
    <section class="columns">
        <section class="column is-half">
            <b-input class="search-field" placeholder="Find..." v-model="filterQuery"></b-input>            
            <template v-for="(place, index) in filteredPlaces">
                <PlaceListComponent :key="place.id" :place="place" :timer="50 * (index+1)"/>
            </template>
        </section>
        
        <section class="column mapbox-wrapper">
            <section id="map">
                <mapbox
                    :access-token="mapBoxToken"
                    :map-options="{
                        style: mapBoxStyle,
                        zoom: 3
                    }"
                    :scale-control="{
                        show: true,
                        position: 'top-left'
                    }"
                    :fullscreen-control="{
                        show: true,
                        position: 'top-left'
                    }">
                </mapbox>
            </section>
        </section>
    </section>
</template>

<script>
    import { mapState } from "vuex";
    import { mapGetters } from "vuex";
    import PlaceListComponent from '@/components/PlacesList/PlaceListComponent';
    import Mapbox from 'mapbox-gl-vue';

    export default {
        name: "SearchPlace",
        components: {
            PlaceListComponent,
            Mapbox,
        },
        data() {
            return {
                mapBoxToken: process.env.MAPBOX_TOKEN,
                mapBoxStyle: process.env.MAPBOX_STYLE,
                filterQuery: ''
            }
        },
        methods: {
        },
        computed: {
            ...mapState("places", ["places"]),
            ...mapGetters("places", ["getFilteredPlaces"]),
            filteredPlaces: function() {
                let places = [];
                if (this.filterQuery) {
                    places = this.getFilteredPlaces(this.filterQuery);
                } else {
                    places = this.places;
                }
                return places;
            }
        }
    }
</script>

<style>
    .mapboxgl-canvas {
        top: 0!important;
        left: 0!important;
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
        top: 260px;
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