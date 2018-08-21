<template>
    <section class="columns">
        <section class="column is-half">
            <template v-for="(place, index) in places">
                <PlacePreview
                    v-if="isPlacesLoaded"
                    :key="place.id"
                    :place="place"
                    :timer="50 * (index+1)"
                />
            </template>
        </section>
        <section class="column mapbox-wrapper right-side">
            <mapbox
                :access-token="getMapboxToken"
                :map-options="{
                    style: getMapboxStyle,
                    center: {
                        lat: 50.4547,
                        lng: 30.5238
                    },
                    zoom: 9
                }"
                :scale-control="{
                    show: true,
                    position: 'top-left'
                }"
                @map-init="mapInitialized"
                @map-load="mapLoaded"
            />
        </section>
    </section>
</template>

<script>
import {mapState} from 'vuex';
import {mapGetters} from 'vuex';
import PlacePreview from './PlacePreview';
import Mapbox from 'mapbox-gl-vue';
import LocationService from '@/services/location/locationService';
import markerUpdater from '@/services/map/markerManagerService';
import {defaultParser} from '@/services/map/markerManagerService';
import placeholderImg from '../../assets/placeholder_128x128.png';

export default {
    name: 'SearchPlace',
    components: {
        PlacePreview,
        Mapbox,
    },
    data() {
        return {
            filterQuery: '',
            isMapLoaded: false,
            isPlacesLoaded: false,
            map: {},
            userCoordinates: {
                lat: 50.4547,
                lng: 30.5238
            },
            setActiveMarkers: null,
        };
    },
    created() {
        this.$store.dispatch('place/fetchPlaces')
            .then(() => {
                this.isPlacesLoaded = true;
            });
    },
    methods: {
        mapInitialized(map) {
            this.map = map;
            LocationService.getUserLocationData()
                .then(coordinates => {
                    this.userCoordinates.lat = coordinates.lat;
                    this.userCoordinates.lng = coordinates.lng;
                });
        },
        mapLoaded(map) {
            this.setActiveMarkers = markerUpdater(defaultParser)(map, {shouldFit: true});
            this.isMapLoaded = true;
        },
        jumpTo(coordinates) {
            this.map.jumpTo({
                center: coordinates,
            });
        },
        createUserMarker() {
            return {
                id: 0,
                latitude: this.userCoordinates.lat,
                longitude: this.userCoordinates.lng,
                localization: {
                    0: {
                        description: 'Your position',
                        language: 'en',
                        name: 'Your position',
                    }
                },
                photoUrl: this.user.avatar_url || 'http://via.placeholder.com/128x128',
            };
        },
        updateMap() {
            if (this.isMapLoaded && this.isPlacesLoaded) {
                this.setActiveMarkers(...this.places);
            }
        },
    },
    watch: {
        isMapLoaded: function (oldVal, newVal) {
            this.updateMap();
        },
        isPlacesLoaded: function (oldVal, newVal) {
            this.updateMap();
        }
    },
    computed: {
        ...mapState('place', ['places']),
        ...mapGetters('place', ['getFilteredByName']),
        ...mapGetters('map', [
            'getMapboxToken',
            'getMapboxStyle'
        ]),
        ...mapGetters({
            user: 'auth/getAuthenticatedUser'
        }),
        filteredPlaces: function () {
            let places = [];
            if (this.filterQuery) {
                places = this.getFilteredByName(this.filterQuery);
            } else {
                places = this.places;
            }
            return places;
        },
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
        position: sticky;
        position: -webkit-sticky;
        top: 0;
        height: 100vh;
        right: 0;
        width: 100%;
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