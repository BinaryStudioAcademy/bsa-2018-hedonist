<template>
    <div class="control">
        <b-field>
            <b-autocomplete
                v-model.trim="findCity.query"
                placeholder="Location"
                :data="findCity.data"
                :open-on-focus="true"
                :loading="findCity.isFetching"
                field="text"
                class="navbar__search-autocomplete"
                @input="loadCities"
                @select="option => this.$emit('select', option)"
            />
            <p v-if="locationAvailable" class="control">
                <button
                    class="button location"
                    @click="findByCurrentLocation"
                    :class="{'enabled': locationEnabled}"
                >
                    <b-icon pack="fas" icon="location-arrow" />
                </button>
            </p>
        </b-field>
    </div>
</template>

<script>
import _ from 'lodash';
import LocationService from '@/services/location/locationService';
import mapSettingsService from '@/services/map/mapSettingsService';
import { mapState, mapActions } from 'vuex';

export default {
    name: 'SearchCity',
    data() {
        return {
            findCity: {
                data: [],
                query: '',
                isFetching: false
            },
            userLocation: {
                center: []
            },
            locationAvailable: true,
            searchPushed: false
        };
    },
    methods: {
        loadCities: _.debounce(function () {
            this.findCity.data = [];
            this.findCity.isFetching = true;
            LocationService.getCityList(mapSettingsService.getMapboxToken(), this.findCity.query)
                .then( res => {
                    this.findCity.data = res;
                    this.findCity.isFetching = false;
                }, response => {
                    this.findCity.isFetching = false;
                });
        }, 250),
        findByCurrentLocation() {
            this.findCity.query = this.$t('search.current_location');
            this.$emit('select', this.userLocation);
            const query = {};

            if(this.userLocation.center[0] && this.userLocation.center[1])
                query.location = this.userLocation.center[0] + ',' + this.userLocation.center[1];
            if(this.placeCategory.id)
                query.category = this.placeCategory.id;
            if(this.page)
                query.page = this.page;
            if(this.place.name)
                query.name = this.place.name;
            if(this.filters.checkin)
                query.checkin = this.filters.checkin;
            if(this.filters.saved)
                query.saved = this.filters.saved;
            if(this.filters.top_rated)
                query.top_rated = this.filters.top_rated;
            if(this.filters.top_reviewed)
                query.top_reviewed = this.filters.top_reviewed;

            console.log(query);

            this.$router.push({
                name: 'SearchPlacePage',
                query: query
            });
        }
    },
    created() {

        LocationService.getUserLocationData()
            .then(coordinates => {
                this.locationAvailable = true;
                this.userLocation.center[0] = coordinates.lng;
                this.userLocation.center[1] = coordinates.lat;
                if (
                    (this.$router.currentRoute.name === 'SearchPlacePage')
                    && !this.searchPushed
                ) {
                    this.searchPushed = true;
                    this.findByCurrentLocation();
                }
            })
            .catch(error => {
                this.locationAvailable = false;
            });
    },
    computed: {
        ...mapState('search', [
            'city',
            'placeCategory',
            'page',
            'filters'
        ]),
        locationEnabled() {
            return this.findCity.query === this.$t('search.current_location');
        }
    }
};
</script>

<style scoped>
    .location {
        color: #b8b8ba;
    }

    .location.enabled {
        color: #167df0;
    }
</style>