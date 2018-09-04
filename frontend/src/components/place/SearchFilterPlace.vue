<template>
    <div class="filter-controls">
        <h5 class="header-visible">Filters:</h5>
        <ul>
            <li 
                v-for="(filterPlace, index) in filterPlaces" 
                class="filter-control"
                :class="{selected: filterPlace.check}"
                :key="filterPlace.id"
            >
                <span v-tooltip.bottom="filterPlace.tooltipText" @click="checkFilter(index)" class="filter-control-span">
                    {{ filterPlace.name }}
                    <i v-if="filterPlace.isLoading" class="fa fa-spinner fa-spin" />
                    <i v-if="filterPlace.check" class="far fa-times-circle" />
                </span>
            </li>
        </ul>
    </div>
</template>


<script>
import { mapActions, mapGetters } from 'vuex';
export default {
    name: 'SearchFilterPlace',
    props: {
        isPlacesLoaded: {
            type: Boolean,
            required: true
        }
    },
    data() {
        return {
            timeDelay: 0,
            filterPlaces: {
                top_rated:{
                    id: 1,
                    name: 'Top Rated',
                    check: false,
                    isLoading: false,
                    tooltipText: 'Click to see places with at least 8 rating'
                },
                saved:{
                    id: 2,
                    name: 'Saved',
                    check: false,
                    isLoading: false,
                    tooltipText: 'Click to see saved places'
                },
                checkin:{
                    id: 3,
                    name: 'Visited',
                    check: false,
                    isLoading: false,
                    tooltipText: 'Click to see visited places'
                },
                top_reviewed:{
                    id: 4,
                    name: 'Top Reviewed',
                    check: false,
                    isLoading: false,
                    tooltipText: 'Click to see places with at least 10 reviews'
                },
            },
        };
    },
    methods: {
        ...mapActions({
            setFilters: 'search/setFilters',
            initFilters: 'search/initFilters'
        }),
        checkFilter(index) {
            if (!this.isPlacesLoaded) {
                return;
            }
            let filterPlaces = this.filterPlaces[index];

            if (filterPlaces.check === false) {
                filterPlaces.isLoading = true;
                filterPlaces.check = !filterPlaces.check;
                this.setFilters({[index]: filterPlaces.check})
                    .then(() => {
                        setTimeout(() => {
                            filterPlaces.isLoading = false;
                        }, 300);
                    });

            } else {
                filterPlaces.check = !filterPlaces.check;
                filterPlaces.isLoading = true;
                this.setFilters({[index]: filterPlaces.check})
                    .then(() => {
                        setTimeout(()=> {
                            filterPlaces.isLoading = false;
                        }, 300);
                    });
            }
        },
        init() {
            this.initFilters();
            for(let filter in this.filterPlaces){
                this.filterPlaces[filter].check = this.getFilter(filter);
            }
        }
    },
    computed: {
        ...mapGetters('search', [ 'getFilter' ]),
    },
    created: function(){
        this.init();
    }

};

</script>

<style lang="scss" scoped>

    .filter-controls {
        background: #f8f8f8;
        border-top: 1px solid #fff;
        border-bottom: 1px solid #e4e4e4;
        padding: 5px 16px 8px 16px;

        .header-visible {
            color: #6e6e6e;
            display: inline-block;
            font-size: 11px;
            float: left;
            margin: 6px 5px 0 0;
            text-shadow: 0 1px 0 #fff;
            line-height: 140%;
            font-weight: bold;
        }

        ul {
            display: inline-block;
            list-style: none;
            margin: 0;
            padding: 0;

            li {
                float: left;
                margin: 0 4px 0 0;
                position: relative;

                &:hover .filter-control-span{
                    border-color: #bbb;
                }

                &.selected .filter-control-span {
                    background-color: #fff;
                    border-color: #bbb;
                    padding: 4px 8px;
                }

                .filter-control-span {
                    border-radius: 2px;
                    background: #f3f3f3;
                    border: solid 1px #dcdcdc;
                    color: #6e6e6e;
                    cursor: pointer;
                    display: inline-block;
                    font-size: 11px;
                    font-weight: bold;
                    margin: 0;
                    padding: 4px 8px;
                    position: relative;
                    text-decoration: none;
                    text-shadow: 0 1px 0 #fff;
                    vertical-align: middle;

                }
            }
        }
    }
</style>
