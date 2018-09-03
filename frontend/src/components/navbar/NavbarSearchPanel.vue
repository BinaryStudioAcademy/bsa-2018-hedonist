<template>
    <div class="navbar-start">
        <Preloader :active="isLoading" />
        <div class="navbar-item">
            <SearchPlaceCategory @select="onSelect" :select-city="location" />
        </div>
        <div class="navbar-item">
            <SearchCity @select="selectCity" ref="selectCityComponent" />
        </div>
        <div class="navbar-item is-paddingless navbar-search-btn">
            <button @click.prevent="search" class="button is-info">
                <span class="icon is-large">
                    <i class="fas fa-lg fa-search" />
                </span>
                <span class="button-title">Search</span>
            </button>
        </div>
    </div>
</template>

<script>
import {mapActions, mapGetters, mapState, mapMutations} from 'vuex';
import Preloader from '@/components/misc/Preloader';
import SearchCity from './SearchCity';
import SearchPlaceCategory from './SearchPlaceCategory';

export default {
    name: 'NavbarSearchPanel',
    data: function(){
        return {
            location: {},
            categoryOrPlace: {},
        };
    },
    computed: {
        ...mapState('search', ['isLoading']),
        ...mapGetters({
            city: 'search/getSelectedCity',
            placeCategory: 'search/getSelectedPlaceCategory',
            place: 'search/getSelectedPlace'
        }),
    },
    components: {
        SearchCity,
        SearchPlaceCategory,
        Preloader
    },
    methods: {
        ...mapActions({
            selectSearchCity: 'search/selectSearchCity',
            updateQueryFilters: 'search/updateQueryFilters',
            selectSearchPlaceOrCategory: 'search/selectSearchPlaceOrCategory',
            setCategoryTags: 'category/fetchCategoryTags',
        }),
        ...mapMutations('search', {
            setLoadingState: 'SET_LOADING_STATE',
        }),
        selectCity(city){
            this.location = city ? city : {};
        },
        selectPlaceOrCategory(categoryOrPlace){
            this.categoryOrPlace = categoryOrPlace ? categoryOrPlace : {};
            if (categoryOrPlace !== null &&
                categoryOrPlace.place !== undefined &&
                categoryOrPlace.city.longitude &&
                categoryOrPlace.city.latitude) {
                let city = {
                    text: categoryOrPlace.city.name,
                    center: [
                        categoryOrPlace.city.longitude,
                        categoryOrPlace.city.latitude
                    ],
                    place_name: categoryOrPlace.city.name
                };
                this.$refs.selectCityComponent.$refs.autocompleteCity.setSelected(city);
            }
        },
        search() {
            this.setLoadingState(true);
            this.selectSearchCity(this.location);
            this.selectSearchPlaceOrCategory(this.categoryOrPlace);
            this.updateQueryFilters();
            this.setLoadingState(false);
        },
        onSelect(query) {
            this.selectPlaceOrCategory(query);

            if (query !== null && query.id) {
                this.setCategoryTags(query.id);
            }
        },
    }
};
</script>


<style lang="scss">
    .navbar__search-autocomplete input {
        padding-right: 2.25em;
    }
</style>

<style lang="scss" scoped>
    .button {
        @media screen and (max-width: 1087px) {
            width: 88%;
        }

        .button-title {
            display: none;

            @media screen and (max-width: 1087px) {
                display: inline-block;
            }
        }

        &:hover {
            background-color: #167df0;

            @media screen and (max-width: 1087px) {
                background-color: #0f77ea;
            }
        }
    }

    .navbar-search-btn {
        @media screen and (max-width: 1087px) {
            text-align: center;
        }
    }
</style>