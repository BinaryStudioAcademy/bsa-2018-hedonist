<template>
    <div class="navbar-start">
        <Preloader :active="isLoading" />
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
import {mapActions , mapState } from 'vuex';
import Preloader from '@/components/misc/Preloader';
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
    computed: {
        ...mapState("search" , ["isLoading"]),
//        showItemState () {
//            return this.$store.state.isLoading
//        }
    },
    components: {
        SearchCity,
        SearchPlaceCategory,
        Preloader
    },
    methods: {
        ...mapActions({
            selectSearchCity: 'search/selectSearchCity',
            selectSearchPlaceCategory: 'search/selectSearchPlaceCategory',
            setLoading: 'search/setLoading'
        }),
        search() {
//            this.$store.commit('search/setLoading' , true);
//                                                                                                                                                                                                                                                                                                                                                                                                                                                                                                                                                                                                                                                                                                                                                                                                                                                                                                                                                                                                                                                                                                                                                                  this.$store.state.isLoading = this.isLoading;
            console.log(this.isLoading);
            let location = '';
            let category = '';
            if (this.location !== null) {
                location = this.location.center[0] + ',' + this.location.center[1];
            }
            if (this.category !== null) {
                category = this.category.id;
            }
            this.$router.push({
                name: 'SearchPlacePage',
                query: {
                    category: category,
                    location: location,
                    page: 1
                }
            });
//            this.isLoading = false;
//            setTimeout(() => {
//                this.$store.dispatch('search/setLoading' , false);
//                console.log(this.isLoading);
//            }, 2000)
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