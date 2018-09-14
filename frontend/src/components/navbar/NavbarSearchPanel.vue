<template>
    <div class="navbar-start">
        <Preloader :active="isLoading" />
        <div class="navbar-item">
            <SearchPlaceCategory 
                @keyup.native.enter="beforeSearch"
                @select="selectItem"
                ref="selectPlaceCategoryComponent" 
                :select-city="location"
                @on-clear="onClear"
            />
        </div>
        <div class="navbar-item">
            <SearchCity @keyup.native.enter="search" @select="selectCity" />
        </div>
        <div class="navbar-item is-paddingless navbar-search-btn">
            <button @click.prevent="search" class="button is-info">
                <span class="icon is-large">
                    <i class="fas fa-lg fa-search" />
                </span>
                <span class="button-title">{{ $t('search.button') }}</span>
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
            place: {},
        };
    },
    computed: {
        ...mapState('search', ['isLoading']),
        ...mapGetters({
            city: 'search/getSelectedCity',
        }),
    },
    components: {
        SearchCity,
        SearchPlaceCategory,
        Preloader
    },
    methods: {
        ...mapActions('search', [
            'selectSearchCity',
            'updateQueryFilters',
            'selectSearchCategory',
            'selectSearchPlace'
        ]),
        selectCity(city) {
            this.location = city ? city : {};
        },
        selectItem(item) {
            if (item === null) {
                this.category = {};
                this.place = {};
            } else {
                if (item.place !== undefined) {
                    this.place = item;
                } else {
                    this.category = item;
                }
            }
        },
        search() {
            if(!_.isEmpty(this.location)) {
                this.selectSearchCity(this.location);
            }
            if (!_.isEmpty(this.category)) {
                this.selectSearchCategory(this.category);
            } else {
                this.selectSearchPlace(this.$refs.selectPlaceCategoryComponent.findItems.query);
            }
            this.updateQueryFilters();
        },
        beforeSearch() {
            if (!_.isEmpty(this.place)) {
                this.$router.push({name: 'PlacePage', params: {id: this.place.id}});
                this.place = {};
                return;
            }
            this.search();
        },
        onClear() {
            this.selectItem(null);
            this.search();
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
        @media screen and (max-width: 911px) {
            width: 88%;
        }

        .button-title {
            display: none;

            @media screen and (max-width: 911px) {
                display: inline-block;
            }
        }

        &:hover {
            background-color: #167df0;

            @media screen and (max-width: 911px) {
                background-color: #0f77ea;
            }
        }
    }

    .navbar-search-btn {
        @media screen and (max-width: 911px) {
            text-align: center;
        }
    }
</style>
