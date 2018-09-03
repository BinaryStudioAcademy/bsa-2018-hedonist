<template>
    <div class="wrapper">
        <div class="columns">
            <div class="column is-half left-side">
                <div class="page-content" v-if="!isLoading">
                    <ListHeader
                        :list-item="userList"
                    />
                    <ListPlaceItem
                        v-for="place in denormolizedPlaces"
                        :key="place.id"
                        :place="place"
                    />
                </div>
            </div>
            <div class="column is-half right-side">
                <mapbox
                    :access-token="mapboxToken"
                    :map-options="{
                        style: mapboxStyle,
                        zoom: 9
                    }"
                    @map-init="mapInitialize"
                />
            </div>
        </div>
    </div>
</template>

<script>
import {mapGetters, mapActions, mapState} from 'vuex';
import ListHeader from '../components/userList/ListHeader';
import ListPlaceItem from '../components/userList/ListPlaceItem';
import Mapbox from 'mapbox-gl-vue';
import markerManager from '@/services/map/markerManager';
import mapSettingsService from '@/services/map/mapSettingsService';

export default {
    name: 'UserListPage',
    components: {ListPlaceItem, ListHeader, Mapbox},
    created() {
        this.getListById(this.$route.params.id);
    },
    data() {
        return {
            markerManager: null,
            mapboxToken: mapSettingsService.getMapboxToken(),
            mapboxStyle: mapSettingsService.getMapboxStyle()
        };
    },
    methods: {
        ...mapActions('userList', ['getListById']),
        mapInitialize(map) {
            this.markerManager = markerManager.getService(map);
        },
        updatePlaceMarkers() {
            if (!this.isLoading && this.markerManager) {
                this.markerManager.setMarkersFromPlacesAndFit(...this.denormolizedPlaces.map((item) => ({
                    id: item.id,
                    name: item.localization[0].name,
                    localization: item.localization,
                    longitude: item.longitude,
                    latitude: item.latitude,
                    photos: [item.photos[0] ? this.photos.byId[item.photos[0]] : null],
                    category: this.categories.byId[item.category],
                    address: item.address
                })));
            }
        }
    },
    computed: {
        ...mapGetters('userList', ['getById']),
        ...mapState('userList', ['isLoading', 'places', 'photos', 'categories']),
        userList() {
            return this.getById(this.$route.params.id);
        },
        denormolizedPlaces() {
            const places = [];
            for (const index of this.userList.places) {
                places.push(this.places.byId[index]);
            }
            return places;
        },
    },
    watch:{
        isLoading(){
            this.updatePlaceMarkers();
        },
        markerManager(){
            this.updatePlaceMarkers();
        }
    }
};
</script>

<style lang="scss" scoped>
    .wrapper {
        padding: 10px 20px;
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

            .left-side {
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