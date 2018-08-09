<template>
    <section class="columns">
        <section class="column is-half">
            <b-input class="search-field" placeholder="Find..." v-model="filterQuery"></b-input>            
            <template v-for="(place, index) in filteredPlaces">
                <PlaceListComponent :key="place.id" :place="place" :timer="50 * (index+1)"/>
            </template>
        </section>
        
        <section id="map" class="column mapbox">
            <mapbox
                access-token="pk.eyJ1IjoiYWxsZXh1cyIsImEiOiJjamttdGE1cmIxM2htM2xtZzQxZXJubGdrIn0.KgivvenlaQUbX8cQxLNiWw"
                :map-options="{
                style: 'mapbox://styles/mapbox/light-v9',
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

<style scoped>
    .search-field {
        margin-bottom: 10px;
    }

    .columns {
        padding-left: 10px;
        padding-right: 10px;
    }

    #map { 
        width: 100%;
        height: 100%;
        min-height: 500px;
    }
</style>