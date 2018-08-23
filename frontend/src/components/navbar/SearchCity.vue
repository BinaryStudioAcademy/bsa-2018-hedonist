<template>
    <div class="control">
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
    </div>
</template>

<script>
import {mapGetters} from 'vuex';
import _ from 'lodash';
import LocationService from '@/services/location/locationService';

export default {
    name: 'SearchCity',
    data() {
        return {
            findCity: {
                data: [],
                query: '',
                isFetching: false
            }
        };
    },
    computed: {
        ...mapGetters('map', ['getMapboxToken']),
    },
    methods: {
        loadCities: _.debounce(function () {
            this.findCity.data = [];
            this.findCity.isFetching = true;
            LocationService.getCityList(this.getMapboxToken,this.findCity.query)
                .then( res => {
                    this.findCity.data = res;
                    this.findCity.isFetching = false;
                }, response => {
                    this.findCity.isFetching = false;
                });
        }, 250)
    }
};
</script>