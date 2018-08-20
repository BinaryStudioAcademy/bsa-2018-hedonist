<template>
    <div class="navbar-start">
        <div class="navbar-item">
            <div class="control">
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
                <SearchCity @select="selectSearchCity" />
            </div>
        </div>
        <div class="navbar-item is-paddingless navbar-search-btn">
            <button class="button">
                <span class="icon is-large">
                    <i class="fas fa-lg fa-search" />
                </span>
                <span class="button-title">Search</span>
            </button>
        </div>
    </div>
</template>

<script>
import {mapState, mapActions} from 'vuex';
import SearchCity from './SearchCity';

export default {
    name: 'NavbarSearchPanel',
    data() {
        return {
            filterQuery: '',
            isShow: false
        };
    },
    components: {
        SearchCity
    },
    methods: {
        ...mapActions({
            selectSearchCity: 'search/selectSearchCity',
            loadCategoriesByQuery: 'placeCategory/loadCategories'
        }),
        onClickOutside() {
            this.isShow = false;
        },
        loadCategories() {
            this.loadCategoriesByQuery(this.filterQuery);
        }
    },
    created() {
        this.loadCategories();
    },
    computed: {
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

    .button {
        color: #fff;
        background-color: #167df0;
        border: none;

        @media screen and (max-width: 1087px) {
            width: 88%;
        }

        &:hover {
            cursor: pointer;

            @media screen and (max-width: 1087px) {
                background-color: #1650f0;
            }
        }

        .button-title {
            display: none;

            @media screen and (max-width: 1087px) {
                display: inline-block;
            }
        }
    }

    .navbar-search-btn {
        @media screen and (max-width: 1087px) {
            text-align: center;
        }
    }
</style>