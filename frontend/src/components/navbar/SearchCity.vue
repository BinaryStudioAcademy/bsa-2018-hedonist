<template>
    <div class="control">
        <b-autocomplete
            v-model.trim="findCity.query"
            placeholder="city..."
            :data="findCity.data"
            :open-on-focus="true"
            :loading="findCity.isFetching"
            field="text"
            @input="loadCities"
            @select="option => selectSearchCity(option)"
        />
    </div>
</template>

<script>
import {mapActions, mapGetters} from 'vuex';
import _ from 'lodash';
import LocationService from '@/services/location/locationService';

export default {
    name: 'SearchCity',
    data() {
        return {
            findCity: {
                data: [],
                name: '',
                selected: null,
                isFetching: false
            },
            filterQuery: '',
            isShow: false
        };
    },
    computed: {
        ...mapGetters('map', ['getMapboxToken']),
    },
    methods: {
        ...mapActions({
            selectSearchCity: 'search/selectSearchCity'
        }),
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