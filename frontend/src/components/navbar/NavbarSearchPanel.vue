<template>
    <div class="navbar-start">
        <div class="navbar-item">
            <SearchPlaceCategory @select="category = $event" />
        </div>
        <div class="navbar-item">
            <SearchCity @select="location = $event" />
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
            selectSearchPlaceCategory: 'search/selectSearchPlaceCategory'
        }),
        search() {
            let location = '';
            let category = '';
            if (this.location !== null) {
                location = this.location.center[0] + ',' + this.location.center[1];
            }
            if (this.category !== null) {
                category = this.category.id;
            }
            this.$router.push({
                path: 'search',
                query: {
                    category: category,
                    location: location,
                    page: 1
                }
            });
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