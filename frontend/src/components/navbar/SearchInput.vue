<template>
    <div class="navbar-start">
        <div class="navbar-item">
            <div class="control has-icons-right">
                <b-autocomplete
                    v-model="filterQuery"
                    placeholder="I'm looking for..."
                    :open-on-focus="true"
                    :data="categories"
                    field="name"
                    @input="loadCategories"
                    @select="option => selected = option"
                />
            </div>
        </div>
        <div class="navbar-item">
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
        </div>
        <div class="navbar-item is-paddingless navbar-search-btn">
            <span class="icon is-large">
                <i class="fas fa-lg fa-search" />
            </span>
        </div>
    </div>
</template>

<script>
import {mapState, mapActions, mapGetters} from 'vuex';
import debounce from 'lodash/debounce';
import httpService from '@/services/common/httpService';

export default {
    name: 'SearchInput',
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
    methods: {
        ...mapActions({
            selectSearchCity: 'city/selectSearchCity',
            loadCategoriesByQuery: 'placeCategory/loadCategories'
        }),
        onClickOutside() {
            this.isShow = false;
        },
        loadCategories() {
            this.loadCategoriesByQuery(this.filterQuery);
        },
        loadCities: debounce(function () {
            this.findCity.data = [];
            if(this.findCity.query) {
                this.findCity.isFetching = true;
                let mapboxCitiesApiUrl = `https://api.mapbox.com/geocoding/v5/mapbox.places/${this.findCity.query}.json?access_token=${this.mapboxToken}&country=ua&autocomplete=true&language=en`;

                httpService.get(mapboxCitiesApiUrl)
                    .then(({ data }) => {
                        this.findCity.data = [...data.features];
                        this.findCity.isFetching = false;
                    }, response => {
                        this.findCity.isFetching = false;
                    });
            }
        }, 250)
    },
    created() {
        this.loadCategories();
    },
    computed: {
        ...mapGetters('map', ['getMapboxToken']),
        ...mapState('placeCategory', ['searchCategories']),
        categories: function () {
            return this.searchCategories;
        }
    }
};
</script>

<style lang="scss" scoped>
    .show-list {
        .input {
            border-radius: 4px 4px 0 0;
        }
        .place-category-list {
            display: block;
        }
    }

    .place-category-list {
        display: none;
        z-index: 999999;
        position: absolute;
        top: 37px;
        width: 100%;
        background: #fff;
        border: 1px solid #7957d5;
        border-top: none !important;
        box-shadow: rgba(0, 0, 0, 0.1) 0 0 2px 0;
        vertical-align: baseline;

        a {
            background: #fff;
            cursor: pointer;
            display: block;
            padding: 5px 10px;
            text-decoration: none;
            zoom: 1;
            color: #333;
            min-height: 32px;
            font-weight: 500;
            font-size: 0.9rem;

            overflow: hidden;
            text-overflow: ellipsis;
            white-space: nowrap;
        }

        a:hover {
            background: #efeff4;
            color: #4e595d;
        }
    }
</style>