<template>
    <div class="navbar-start">
        <div class="navbar-item">
            <SearchPlaceCategory @select="selectCategory" />
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
import {mapActions} from 'vuex';
import SearchCity from './SearchCity';
import SearchPlaceCategory from './SearchPlaceCategory';

export default {
    name: 'NavbarSearchPanel',
    data() {
        return {
            category: null,
            location: null,
        };
    },
    components: {
        SearchCity,
        SearchPlaceCategory
    },
    methods: {
        ...mapActions({
            selectSearchCity: 'search/selectSearchCity',
            selectSearchPlaceCategory: 'search/selectSearchPlaceCategory',
            updateQueryFilters: 'search/updateQueryFilters'
        }),
        selectCity(city){
            this.location = city;
        },
        selectCategory(category){
            this.category = category;
        },
        search() {
            this.selectSearchCity(this.location);
            this.selectSearchPlaceCategory(this.category);
            this.updateQueryFilters();
        }
    },
};
</script>


<style lang="scss">
    .navbar__search-autocomplete input{
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