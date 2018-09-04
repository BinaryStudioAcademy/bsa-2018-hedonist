<template>
    <div class="container">
        <Preloader :active="isLoading" />
        <Form
            :attachedPlaces="attachedPlaces"
            :list-image="userListImageUrl"
            :list-name="userListName"
            :id="parseInt(id)"
            v-if="!isLoading"
            @loading="loading"
        />
        <SearchPlaces
            :list-attached-places="attachedPlaces"
            @changeAttachedPlaces="changeAttachedPlaces"
        />
        <div class="map">
            <div class="mapbox-wrapper">
                <mapbox
                    :access-token="mapboxToken"
                    :map-options="{
                        style: mapboxStyle,
                        center: {
                            lat: 48.26,
                            lng: 31.31
                        },
                        zoom: 4.2
                    }"
                    :scale-control="{
                        show: true,
                        position: 'top-left'
                    }"
                    @map-init="mapInitialize"
                />
            </div>
        </div>
        <back-to-top>
            <button type="button" class="btn btn-info btn-to-top">
                <i class="fa fa-chevron-up" />
            </button>
        </back-to-top>
    </div>

</template>

<script>
import Form from '@/components/userList/Form';
import SearchPlaces from '@/components/userList/SearchPlaces';
import mapSettingsService from '@/services/map/mapSettingsService';
import markerManager from '@/services/map/markerManager';
import Mapbox from 'mapbox-gl-vue';
import BackToTop from 'vue-backtotop';
import { mapGetters, mapActions } from 'vuex';
import Preloader from '@/components/misc/Preloader';

export default {
    name: 'UserListAddUpdatePage',
    components: {
        SearchPlaces,
        Mapbox,
        Form,
        BackToTop,
        Preloader
    },
    data: function() {
        return {
            mapboxToken: mapSettingsService.getMapboxToken(),
            mapboxStyle: mapSettingsService.getMapboxStyle(),
            markerManager: null,
            attachedPlaces: [],
            userListName: null,
            userListImageUrl: null,
            isLoading: true,
            id: null
        };
    },
    created() {
        if (!this.$route.params.id) {
            this.isLoading = false;
            return;
        }

        this.id = this.$route.params.id;
        this.fetchListById(this.id)
            .then(() => {
                const userList  = this.getUserListById(this.id);
                this.userListName = userList.name;
                this.userListImageUrl = userList['img_url'];
                this.attachedPlaces = this.getPlacesByIds(userList.places);
                this.isLoading = false;
            });
    },
    computed: {
        ...mapGetters({
            getUserListById: 'userList/getById',
            getPlacesByIds: 'userList/getPlacesByIds'
        }),
    },
    methods: {
        ...mapActions({ fetchListById: 'userList/getListById' }),
        mapInitialize(map) {
            this.markerManager = markerManager.getService(map);
        },
        changeAttachedPlaces(places) {
            this.attachedPlaces = places;
            this.markerManager.setMarkersFromPlacesAndFit(...this.attachedPlaces);
        },
        loading(value) {
            this.isLoading = value;
        }
    }
};
</script>

<style lang="scss" scoped>
    .container {
        border-radius: 3px;
        background: #fff;
        position: relative;
        display: grid;
        grid-template-columns: 1.2fr 0.8fr;
        grid-template-rows: 214px auto;
        grid-template-areas: "form map" "places map";
        margin-top: 40px;
    }

    .btn-to-top {
        display: none;
        width: 60px;
        height: 60px;
        padding: 10px 16px;
        border-radius: 50%;
        font-size: 22px;
        line-height: 22px;
    }

    .map {
        grid-area: map;
        border-left: 1px solid #e8e9eb;
        border-top: 1px solid #e8e9eb;
        position: relative;

        .mapbox-wrapper {
            position: sticky;
            top: 50px;
            height: calc(100vh - 50px);

            #map {
                text-align: justify;
                position: absolute;
                top: 0;
                bottom: 0;
                right: 0;
                width: 100%;
            }
        }
    }

    @media screen and (max-width: 769px) {
        .container {
            grid-template-areas: "form" "map" "places";
            grid-template-columns: auto;
            grid-template-rows: auto;
        }

        .map {
            .mapbox-wrapper {
                height: 50vh;
            }
        }
        .btn-to-top {
            display: block;
        }
    }
</style>