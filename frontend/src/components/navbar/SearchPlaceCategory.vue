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
            ref="autocomplete"
        >

            <template slot-scope="props">
                <div class="search-block" v-if="props.option.place === undefined">
                    <img :src="props.option.logo">
                    <span>{{ props.option.name }}</span>
                </div>
                <router-link v-else :to="`/places/${props.option.id}`">
                    <div class="search-block">
                        <img :src="props.option.logo">
                        <span>{{ props.option.nameForAutoComplete }}</span>
                    </div>
                </router-link>
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
                        this.findItems.data = res;
                        this.findItems.isFetching = false;
                    }, response => {
                        this.findItems.isFetching = false;
                    });
            } else {
                let polygon = '';
                if (!_.isEmpty(this.selectCity)) {
                    polygon = this.createPolygonByBBox(this.selectCity.bbox);
                    console.log(polygon);
                }
                this.loadPlaces({name: this.findItems.query, polygon: polygon})
                    .then( res => {
                        let data = [];
                        res.forEach(function (item, index) {
                            data[index] = {
                                id: item['id'],
                                logo: item['photo']['img_url'],
                                nameForAutoComplete: item['localization'][0]['name'] + ' - ' + item['city']['name'],
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
        createPolygonByBBox(bbox) {
            const x1 = bbox[0];
            const y1 = bbox[1];
            const x2 = bbox[2];
            const y2 = bbox[3];

            return x1 + ',' + y1 + ';' + x2 + ',' + y1 + ';' + x2 + ',' + y2 + ';' + x1 + ',' + y2 + ';' + x1 + ',' + y1;
        }
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
        cursor: pointer;
        color: #4a4a4a;
        margin: -0.375rem -1rem;
        margin-right: -3rem;
        padding: 0.375rem 1rem;
        padding-right: 3rem;
    }

    .search-block img{
        margin-right: 5px;
    }
</style>
