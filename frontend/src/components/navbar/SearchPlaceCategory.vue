<template>
    <div class="control">
        <b-autocomplete
            v-model.trim="findPlaceCategory.query"
            placeholder="I'm looking for..."
            :data="findPlaceCategory.data"
            :open-on-focus="true"
            :loading="findPlaceCategory.isFetching"
            class="navbar__search-autocomplete"
            field="name"
            @input="loadCategories"
            @select="option => this.$emit('select', option)"
        />
    </div>
</template>

<script>

import {mapActions} from 'vuex';
import _ from 'lodash';

export default {
    name: 'SearchPlaceCategory',
    data() {
        return {
            findPlaceCategory: {
                data: [],
                query: '',
                isFetching: false
            },
        };
    },
    methods: {
        ...mapActions({
            loadCategoriesByName: 'search/loadCategories'
        }),
        loadCategories: _.debounce(function () {
            this.findPlaceCategory.data = [];
            this.findPlaceCategory.isFetching = true;
            this.loadCategoriesByName(this.findPlaceCategory.query)
                .then( res => {
                    this.findPlaceCategory.data = res;
                    this.findPlaceCategory.isFetching = false;
                }, response => {
                    this.findPlaceCategory.isFetching = false;
                });
        }, 250),
        init() {
            this.loadCategoriesByName(this.findPlaceCategory.query)
                .then( res => {
                    this.findPlaceCategory.data = res;
                });
        }
    },
    created() {
        this.init();
    }
};
</script>