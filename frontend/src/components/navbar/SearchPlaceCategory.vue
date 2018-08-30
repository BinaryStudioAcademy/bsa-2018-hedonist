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
            @select="onSelect"
        >

            <template slot-scope="props">
                <div class="search-block">
                    <img :src="props.option.logo">
                    <span>{{ props.option.name }}</span>
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
        ...mapActions('category', [
            'fetchCategoryTags',
            'resetCategoryTags',
        ]),
        loadItems: _.debounce(function () {
            this.findItems.data = [];
            this.findItems.isFetching = true;
            if (this.findItems.query === '') {
                this.loadCategoriesByName(this.findItems.query)
                    .then( res => {
                        this.findItems.data = res;
                        this.findItems.isFetching = false;
                    }, response => {
                        this.findItems.isFetching = false;
                    });
            } else {
                let location = '';
                if (this.city !== null) {
                    location = this.city.longitude + ',' + this.city.latitude;
                }
                this.loadPlaces({name: this.findItems.query, location: location})
                    .then( res => {
                        let data = [];
                        res.forEach(function (item, index) {
                            data[index] = {
                                logo: item['photo']['img_url'],
                                name: item['localization'][0]['name'],
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
                    this.findItems.data = res;
                });
        },
        onSelect(option) {
            if (option) {
                this.$emit('select', option);
                this.fetchCategoryTags(option.id);
            } else {
                this.resetCategoryTags();
            }
        },
    },
    created() {
        this.init();
    },
    computed: {
        ...mapGetters({
            city: 'search/getSelectedCity'
        }),
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
