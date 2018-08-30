<template>
    <div class="wrapper">
        <div class="columns">
            <div class="column is-half">
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
            <div class="column is-half">
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
    data(){
        return{
            markerManager: null,
            mapboxToken: mapSettingsService.getMapboxToken(),
            mapboxStyle: mapSettingsService.getMapboxStyle()
        };
    },
    methods: {
        ...mapActions('userList', ['getListById']),
        mapInitialize(map){
            this.markerManager = markerManager.getService(map);
        },
        updatePlaceMarkers(places){
            if(this.markerManager && !this.isLoading){
                this.markerManager.setMarkersFromPlacesAndFit(...places.map((item) => ({
                    id:item.id,
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
        ...mapState('userList', ['isLoading', 'places','photos','categories']),
        userList() {
            return this.getById(this.$route.params.id);
        },
        denormolizedPlaces() {
            const places = [];
            for (const index of this.userList.places) {
                places.push(this.places.byId[index]);
            }
            this.updatePlaceMarkers(places);
            return places;
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
        position: sticky;
        position: -webkit-sticky;
        top: 3.75rem;
        height: 100vh;
        right: 0;
        width: 100%;
    }
</style>