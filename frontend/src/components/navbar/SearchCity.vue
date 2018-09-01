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
import { mapState, mapMutations, mapActions } from 'vuex';
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
        ...mapMutations('search', {
            setCity: 'SET_SEARCH_CITY',
            setCurrentPosition: 'SET_CURRENT_POSITION',
        }),
        ...mapActions('search', ['updateQueryFilters']),
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

            if(!this.city.latitude || !this.city.longitude)
                this.setCity(this.userLocation);

            this.updateQueryFilters();

//            query.location = this.userLocation.center[0] + ',' + this.userLocation.center[1];
//            query.page = this.page || 1;
//
//            this.$router.push({
//                name: 'SearchPlacePage',
//                query: query
//            });
        },
    },
    created() {
//        console.log('this.location',this.location);
//        console.log('this.$route.query.location',this.$route.query.location);
//        if(!this.location) {
            LocationService.getUserLocationData()
                .then(coordinates => {
                    this.locationAvailable = true;
                    this.userLocation.center[0] = coordinates.lng;
                    this.userLocation.center[1] = coordinates.lat;
                    if ((this.$router.currentRoute.name === 'SearchPlacePage') && !this.searchPushed) {
                        this.searchPushed = true;
                        this.findByCurrentLocation();
                    }
                })
                .catch(error => {
                    this.locationAvailable = false;
                });
//        }
    },
    computed: {
        ...mapState('search', ['currentPosition', 'location', 'page', 'city']),
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