<template>
    <div class="navbar-start">
        <Preloader :active="isLoading" />
        <div class="navbar-item">
            <SearchPlaceCategory @select="selectSearchPlaceOrCategory" />
        </div>
        <div class="navbar-item">
            <SearchCity @select="selectSearchCity" />
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
            selectSearchPlaceOrCategory: 'search/selectSearchPlaceOrCategory',
        }),
        ...mapMutations('search', {
            setLoadingState: 'SET_LOADING_STATE',
        }),
        search() {
            this.setLoadingState(true);
            let location = '';
            let category = '';
            let placeName = '';
            if (this.city !== null) {
                location = this.city.longitude + ',' + this.city.latitude;
            }
            if (this.placeCategory !== null) {
                category = this.placeCategory.id;
            }
            if (this.place !== null) {
                placeName = this.place.name;
            }

            this.$router.push({
                name: 'SearchPlacePage',
                query: {
                    category: category,
                    location: location,
                    searchName: placeName,
                    page: 1
                }
            });

        }
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