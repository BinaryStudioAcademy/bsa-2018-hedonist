<template>
    <section class="columns">
        <section class="column is-half">
            <b-input class="search-field" placeholder="Find..." v-model="filterQuery"></b-input>            
            <template v-for="(place, index) in filteredPlaces">
                <PlaceListComponent :key="place.id" :place="place" :timer="50 * (index+1)"/>
            </template>
        </section>
        <section class="column mapbox">

        </section>
    </section>
</template>

<script>
    import { mapState } from "vuex";
    import { mapGetters } from "vuex";
    import PlaceListComponent from '@/components/PlacesList/PlaceListComponent';

    export default {
        name: "SearchPlace",
        components: {
            PlaceListComponent
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
</style>