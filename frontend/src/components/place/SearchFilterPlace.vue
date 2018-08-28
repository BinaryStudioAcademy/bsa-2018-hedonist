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

export default {
    name: 'SearchFilterPlace',
    data() {
        return {
            timeDelay: 0,
            filterPlaces: [
                {
                    id: 1,
                    name: 'saved',
                    check: false,
                    isLoading: false,
                    tooltipText: 'Click to see saved places'
                },
                {
                    id: 2,
                    name: 'checkin',
                    check: false,
                    isLoading: false,
                    tooltipText: 'Click to see checked places'
                },
                {
                    id: 3,
                    name: 'not visited',
                    check: false,
                    isLoading: false,
                    tooltipText: 'Click to see not visited places'
                },
            ],
        };
    },
    methods: {
        checkFilter(index) {
            let filterPlaces = this.filterPlaces[index];

            if (filterPlaces.check === false) {
                filterPlaces.isLoading = true;
                setTimeout(function () {
                    filterPlaces.isLoading = false;
                    filterPlaces.check = !filterPlaces.check;
                }, 300);
            } else {
                filterPlaces.check = !filterPlaces.check;
                filterPlaces.isLoading = true;
                setTimeout(function () {
                    filterPlaces.isLoading = false;

                }, 300);
            }
        }
    },
    computed: {},

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
