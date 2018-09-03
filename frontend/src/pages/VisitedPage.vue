<template>
    <section class="columns">
        <Preloader :active="isLoading" />
        <section class="column is-half">

            <CheckInsContainer :check-ins="checkIns" />
        </section>

        <section class="column mapbox-wrapper right-side">
            <HistoryMap />
        </section>
    </section>
</template>

<script>
import {mapState} from 'vuex';
import Preloader from '@/components/misc/Preloader';
import CheckInsContainer from '@/components/history/CheckInsContainer';
import HistoryMap from '@/components/history/HistoryMap';

export default {
    name: 'VisitedPage',
    components: {
        Preloader,
        CheckInsContainer,
        HistoryMap
    },

    computed: {
        ...mapState('history', [
            'checkIns',
            'isLoading'
        ]),
    }
};
</script>

<style>
    .mapboxgl-canvas {
        top: 0 !important;
        left: 0 !important;
    }

    .mapboxgl-marker {
        cursor: pointer;
    }

    .mapboxgl-popup-close-button{
        font-size: 22px;
    }

    .link-place:hover{
        text-decoration: underline;
    }
</style>

<style lang="scss" scoped>
    .search-field {
        margin-bottom: 10px;
    }

    .columns {
        padding: 10px;
    }

    #map {
        text-align: justify;
        position: fixed;
        top: 63px;
        height: 100vh;
        right: 4px;
        width: 49%;
    }

    @media screen and (max-width: 769px) {
        .columns {
            display: grid;
            grid-template-areas: "right" "left";

            .is-half {
                grid-area: left;
            }
            .right-side {
                grid-area: right;
            }
        }
        #map {
            text-align: justify;
            vertical-align: top;
            position: relative;
            top: 0;
            left: 0;
            width: 100%;
            height: 500px;
        }
    }

    @media screen and (max-width: 520px) {
        #map {
            height: 300px;
        }
    }
</style>
