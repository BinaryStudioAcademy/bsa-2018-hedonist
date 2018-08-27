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
                    <b-icon pack="fas" icon="location-arrow"></b-icon>
                </button>
            </p>
        </b-field>
    </div>
</template>

<script>
import _ from 'lodash';
import LocationService from '@/services/location/locationService';
import mapSettingsService from '@/services/map/mapSettingsService';

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
            locationAvailable: true
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
            this.findCity.query = 'Current location';
            this.$emit('select', this.userLocation);
        }
    },
    created() {
        LocationService.getUserLocationData()
            .then(coordinates => {
                this.locationAvailable = true;
                this.userLocation.center[0] = coordinates.lng;
                this.userLocation.center[1] = coordinates.lat;
            })
            .catch(error => {
                this.locationAvailable = false;
            });
    },
    computed: {
        locationEnabled() {
            return this.findCity.query === 'Current location';
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