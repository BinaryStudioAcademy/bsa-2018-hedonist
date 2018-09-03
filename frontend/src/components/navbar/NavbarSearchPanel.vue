<template>
    <div class="navbar-start">
        <Preloader :active="isLoading" />
        <div class="navbar-item">
            <SearchPlaceCategory @select="onSelect" ref="selectPlaceCategoryComponent" :select-city="location" />
        </div>
        <div class="navbar-item">
            <SearchCity @select="selectCity" />
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
            category: {},
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
            selectSearchCategory: 'search/selectSearchCategory',
            setCategoryTags: 'category/fetchCategoryTags',
            selectSearchPlace: 'search/selectSearchPlace',
        }),
        ...mapMutations('search', {
            setLoadingState: 'SET_LOADING_STATE',
        }),
        selectCity(city){
            this.location = city ? city : {};
        },
        selectCategory(category){
            this.category = category ? category : {};
        },
        search() {
            this.setLoadingState(true);
            if(!_.isEmpty(this.location)) {
                this.selectSearchCity(this.location);
            }
            if (!_.isEmpty(this.category)) {
                this.selectSearchCategory(this.category);
            } else {
                this.selectSearchPlace(this.$refs.selectPlaceCategoryComponent.$refs.autocomplete.value);
            }
            this.updateQueryFilters();
            this.setLoadingState(false);
        },
        onSelect(query) {
            this.selectCategory(query);

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
