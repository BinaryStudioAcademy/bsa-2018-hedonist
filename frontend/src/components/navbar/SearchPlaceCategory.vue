<template>
    <div class="control">
        <b-autocomplete
            v-model.trim="findItems.query"
            placeholder="I'm looking for..."
            :data="findItems.data"
            :open-on-focus="true"
            :loading="findItems.isFetching"
            class="navbar__search-autocomplete"
            field="name"
            @input="loadItems"
            @select="option => this.$emit('select', option)"
        >

            <template slot-scope="props">
                <div class="search-block">
                    <img :src="props.option.logo">
                    <span>{{ props.option.nameForAutoComplete }}</span>
                </div>

            </template>
        </b-autocomplete>
    </div>
</template>

<script>

import {mapActions, mapGetters} from 'vuex';
import _ from 'lodash';

export default {
    name: 'SearchPlaceCategory',
    props: {
        selectCity: {
            type: Object,
            required: true
        }
    },
    data() {
        return {
            findItems: {
                data: [],
                query: '',
                isFetching: false
            },
        };
    },
    methods: {
        ...mapActions({
            loadCategoriesByName: 'search/loadCategories',
            loadPlaces: 'search/loadPlaces'
        }),
        loadItems: _.debounce(function () {
            this.findItems.data = [];
            this.findItems.isFetching = true;
            if (this.findItems.query === '') {
                this.loadCategoriesByName(this.findItems.query)
                    .then( res => {
                        let data = [];
                        res.forEach(function (item, index) {
                            data[index] = {
                                id: item['id'],
                                nameForAutoComplete: item['name'],
                                name: item['name'],
                                logo: item['logo']
                            };
                        });
                        this.findItems.data = data;
                        this.findItems.isFetching = false;
                    }, response => {
                        this.findItems.isFetching = false;
                    });
            } else {
                let location = '';
                if (!_.isEmpty(this.selectCity)) {
                    location = this.selectCity.center[0] + ',' + this.selectCity.center[1];
                }
                this.loadPlaces({name: this.findItems.query, location: location})
                    .then( res => {
                        let data = [];
                        res.forEach(function (item, index) {
                            data[index] = {
                                logo: item['photo']['img_url'],
                                nameForAutoComplete: item['localization'][0]['name'] + ' - ' + item['city']['name'],
                                name: item['localization'][0]['name'],
                                city: item['city'],
                                place: true
                            };
                        });
                        this.findItems.data = data;
                        this.findItems.isFetching = false;
                    }, response => {
                        this.findItems.isFetching = false;
                    });
            }

        }, 250),
        init() {
            this.loadCategoriesByName(this.findItems.query)
                .then( res => {
                    let data = [];
                    res.forEach(function (item, index) {
                        data[index] = {
                            id: item['id'],
                            nameForAutoComplete: item['name'],
                            name: item['name'],
                            logo: item['logo']
                        };
                    });
                    this.findItems.data = data;
                });
        },
    },
    created() {
        this.init();
    }
};
</script>

<style>
    .search-block{
        display: flex;
        align-items: center;
    }

    .search-block img{
        margin-right: 5px;
    }
</style>
