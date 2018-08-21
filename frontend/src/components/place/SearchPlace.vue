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
                    center: currentCenter,
                    zoom: 9
                }"
                :scale-control="{
                    show: true,
                    position: 'top-left'
                }"
                @map-init="mapInitialize"
                @map-load="mapLoaded"
            />
        </section>
    </section>
</template>

<script>
import { mapState, mapGetters, mapActions } from 'vuex';
import PlacePreview from './PlacePreview';
import Mapbox from 'mapbox-gl-vue';
import LocationService from '@/services/location/locationService';
import MarkerService from '@/services/map/markerManagerService';

let markerManager = null;

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
        };
    },
    created() {
        this.$store.dispatch('place/fetchPlaces')
            .then(() => {
                this.isPlacesLoaded = true;
                if (this.isMapLoaded) {
                    this.updateMap(this.places);
                    markerManager.fitMarkersOnMap();
                    this.setCurrentCenter(markerManager.getCurrentCenter());
                }
            });
    },
    methods: {
        ...mapActions('search', ['setCurrentCenter', 'mapInitialization']),

        mapInitialize(map) {
            if (this.mapInitialized) {
                return;
            }

            this.map = map;
            LocationService.getUserLocationData()
                .then(coordinates => {
                    this.userCoordinates.lat = coordinates.lat;
                    this.userCoordinates.lng = coordinates.lng;
                });
            this.mapInitialization();
        },
        mapLoaded(map) {
            markerManager = new MarkerService(map);
            this.isMapLoaded = true;
            if (this.isPlacesLoaded) {
                this.updateMap(this.places);
                markerManager.fitMarkersOnMap();
                this.setCurrentCenter(markerManager.getCurrentCenter());
            }
        },
        jumpTo(coordinates) {
            this.map.jumpTo({
                center: coordinates,
            });
        },
        updateMap(places) {
            markerManager.setMarkers(...places);
        },
        createUserMarker(){
            return {
                id           : 0,
                latitude     : this.userCoordinates.lat,
                longitude    : this.userCoordinates.lng,
                localization : {
                    0: {
                        description: 'Your position',
                        language: 'en',
                        name: 'Your position',
                    }
                },
                photoUrl: this.user.avatar_url || 'http://via.placeholder.com/128x128',
            };
        },
    },
    computed: {
        ...mapState('place', ['places']),
        ...mapState('search', ['currentLatitude', 'currentLongitude', 'mapInitialized']),
        ...mapGetters('place', ['getFilteredByName']),
        ...mapGetters('map', [
            'getMapboxToken',
            'getMapboxStyle'
        ]),
        ...mapGetters({
            user: 'auth/getAuthenticatedUser'
        }),

        currentCenter() {
            return {
                lat: this.currentLatitude ? this.currentLatitude : this.userCoordinates.lat,
                lng: this.currentLongitude ? this.currentLongitude : this.userCoordinates.lng
            };
        },

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