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
            selectedCity: {
                center: [],
                name: ''
            },
            searchPushed: false
        };
    },
    methods: {
        ...mapMutations('search', {
            setCity: 'SET_SEARCH_CITY',
        }),
        ...mapActions('search', ['updateQueryFilters', 'setLocationAvailable', 'setCurrentPosition']),
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
            this.$emit('select', this.selectedCity);
            this.setCity(this.selectedCity);
            this.updateQueryFilters();
        },
    },
    created() {
        LocationService.getUserLocationData()
            .then(coordinates => {
                this.setLocationAvailable(true);
                this.findCity.query = this.$t('search.current_location');
                this.selectedCity.center[0] = coordinates.lng;
                this.selectedCity.center[1] = coordinates.lat;
            })
            .catch(error => {
                this.setLocationAvailable(false);
            });
    },
    computed: {
        ...mapState('search', ['currentPosition', 'location', 'page', 'city', 'locationAvailable']),
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