<template>
    <div class="navbar-start">
        <div class="navbar-item">
            <SearchPlaceCategory @select="selectSearchPlaceCategory" />
        </div>
        <div class="navbar-item">
            <SearchCity @select="selectSearchCity" />
        </div>
        <div class="navbar-item is-paddingless navbar-search-btn">
            <button @click.prevent="search" class="button is-info">
                <i class="fas fa-lg fa-search" />
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
    components: {
        SearchCity,
        SearchPlaceCategory
    },
    methods: {
        ...mapActions({
            selectSearchCity: 'search/selectSearchCity',
            selectSearchPlaceCategory: 'search/selectSearchPlaceCategory'
        }),
        search() {
            //TODO: implement search by city and category
        }
    },
};
</script>

<style lang="scss" scoped>

</style>