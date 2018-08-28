<template>
    <div class="row">
        <div class="column visitedplaces-wrapper">
            <CheckInsContainer :check-ins="checkIns" />
        </div>

        <div class="column mapbox-wrapper">
            <HistoryMap />
        </div>
    </div>
</template>

<script>
import { mapState } from 'vuex';
import CheckInsContainer from '@/components/history/CheckInsContainer';
import HistoryMap from '@/components/history/HistoryMap';

export default {
    name: 'CheckinsPage',
    components: {
        CheckInsContainer,
        HistoryMap
    },
    
    computed: {
        ...mapState('history', [
            'checkIns',
        ]),
    }
};
</script>

<style>
    .mapboxgl-ctrl-top-left,
    .mapboxgl-ctrl-top-right {
        top: 20px;
    }
</style>

<style lang="scss" scoped>
    .row {
        display: flex;
    }

    .column {
        flex: 50%;
    }

    .no-visited-places {
        text-align: center;
    }

    @media screen and (max-width: 769px) {
        .row {
            display: grid;
            grid-template-areas: "right" "left";

            .visitedplaces-wrapper {
                grid-area: left;
            }

            .mapbox-wrapper {
                grid-area: right;
                position: relative;
                height: 500px;
            }
        }

        .column {
            flex: 100%;
        }
    }

    @media screen and (max-width: 520px) {
        .row {
            .mapbox-wrapper {
                height: 300px;
            }
        }
    }
</style>
