<template>
    <div class="control">
        <b-field class="search-wrp">
            <b-autocomplete
                v-model.trim="findItems.query"
                :placeholder="$t('search.looking_for')"
                :data="findItems.data"
                :open-on-focus="true"
                :loading="findItems.isFetching"
                class="navbar__search-autocomplete"
                field="name"
                @input="loadItems"
                @select="option => this.$emit('select', option)"
                ref="autocomplete"
                @keyup.native.enter="$emit('keyup.native.enter')"
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
            <p class="control" v-if="showClearButton">
                <button
                    class="button"
                    @click="clearInput"
                >
                    <b-icon pack="far" icon="times-circle" />
                </button>
            </p>
        </b-field>
    </div>
</template>

<script>

import {mapActions, mapMutations, mapGetters, mapState} from 'vuex';
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
            loadPlaces: 'search/loadPlaces',
            fetchAllCategories: 'category/fetchAllCategories'
        }),
        ...mapMutations('search',{
            setSelectedTags: 'SET_SELECTED_TAGS'
        }),
        clearInput(){
            this.findItems.query = '';
            this.setSelectedTags(
                []
            );
        },
        loadItems: _.debounce(function () {
            this.findItems.data = [];
            this.findItems.isFetching = true;
            if (this.findItems.query === '') {
                this.findItems.data = Object.values(this.allCategories);
                this.findItems.isFetching = false;
            } else {
                let polygon = '';
                if (!_.isEmpty(this.selectCity)) {
                    polygon = this.createPolygonByBBox(this.selectCity.bbox);
                }
                this.loadPlaces({name: this.findItems.query, polygon: polygon})
                    .then(res => {
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
            this.fetchAllCategories()
                .then( (res) => {
                    this.findItems.data = Object.values(this.allCategories);

                    if (this.$route.query.category !== undefined && this.findItems.query === '') {
                        this.findItems.query = this.getById(this.$route.query.category).name;
                    }
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
    },
    computed: {
        ...mapState('category', ['allCategories']),
        ...mapGetters('category' , ['getById']),
        showClearButton(){
            return !!this.findItems.query;
        }
    },
    watch: {
        '$route.query.name': function(name) {
            if (name !== undefined && this.findItems.query === '') {
                this.findItems.query = name;
            }
        }
    },
};
</script>

<style>
    .search-block {
        display: flex;
        align-items: center;
        cursor: pointer;
        color: #4a4a4a;
        margin: -0.375rem -1rem;
        margin-right: -3rem;
        padding: 0.375rem 1rem;
        padding-right: 3rem;
    }

    .search-block img {
        margin-right: 5px;
    }

    .search-wrp {
        width: 176px;
    }
</style>
