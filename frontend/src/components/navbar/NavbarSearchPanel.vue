<template>
    <div class="navbar-start">
        <div class="navbar-item">
            <SearchPlaceCategory @select="selectSearchPlaceCategory" />
        </div>
        <div class="navbar-item">
            <SearchCity @select="selectSearchCity" />
        </div>
        <div class="navbar-item is-paddingless navbar-search-btn">
            <span class="icon is-large">
                <i class="fas fa-lg fa-search" />
            </span>
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
        })
    },
};
</script>

<style lang="scss" scoped>

</style>