<template>
    <section class="columns">
        <section class="column is-half">
            <SearchFilterPlace />
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
                :access-token="mapboxToken"
                :map-options="{
                    style: mapboxStyle,
                    center: currentCenter,
                    zoom: 9
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
import MapboxDraw from '@mapbox/mapbox-gl-draw';
import SearchFilterPlace from './SearchFilterPlace';
import LocationService from '@/services/location/locationService';
import markerManager from '@/services/map/markerManager';
import placeholderImg from '@/assets/placeholder_128x128.png';
import mapSettingsService from '@/services/map/mapSettingsService';

export default {
    name: 'SearchPlace',
    components: {
        PlacePreview,
        Mapbox,
        SearchFilterPlace
    },
    data() {
        return {
            filterQuery: '',
            isMapLoaded: false,
            isPlacesLoaded: false,
            map: {},
            markerManager: null,
            mapboxToken: mapSettingsService.getMapboxToken(),
            mapboxStyle: mapSettingsService.getMapboxStyle(),
            draw: {}
        };
    },
    created() {
        this.$store.dispatch('place/fetchPlaces', this.$route.query)
            .then(() => {
                this.isPlacesLoaded = true;
            });
    },
    methods: {
        ...mapActions('search', ['setCurrentPosition', 'mapInitialization']),

        mapInitialize(map) {
            if (this.mapInitialized) {
                return;
            }

            this.map = map;
            LocationService.getUserLocationData()
                .then(coordinates => {
                    this.setCurrentPosition({
                        latitude: coordinates.lat,
                        longitude: coordinates.lng
                    });
                });
            this.mapInitialization();
        },
        mapLoaded(map) {
            map = this.addDrawForMap(map);
            this.markerManager = markerManager.getService(map);
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
                latitude: this.currentPosition.latitude,
                longitude: this.currentPosition.longitude,
                localization: {
                    0: {
                        description: 'Your position',
                        language: 'en',
                        name: 'Your position',
                    }
                },
                photoUrl: this.user.avatar_url || placeholderImg,
            };
        },
        updateMap() {
            if (this.isMapLoaded && this.isPlacesLoaded) {
                this.markerManager.setMarkersFromPlacesAndFit(...this.places);
            }
        },
        addDrawForMap(map) {
            this.draw = new MapboxDraw({
                displayControlsDefault: false,
                controls: {
                    polygon: true
                }
            });
            map.addControl(this.draw, 'top-left');
            map.on('draw.create', this.updateSearchArea);

            return map;
        },
        updateSearchArea() {
            let data = this.draw.getAll();
            let query = this.$route.query;
            if (data.features.length > 0) {
                query.polygon = data.features.map(item => item.geometry.coordinates[0]);
            }

            this.isPlacesLoaded = false;
            this.$store.dispatch('place/fetchPlaces', query)
                .then(() => {
                    this.isPlacesLoaded = true;
                    this.draw.deleteAll();
                });
        }
    },
    watch: {
        isMapLoaded: function (oldVal, newVal) {
            if (this.isPlacesLoaded) {
                this.updateMap();
            }
        },
        isPlacesLoaded: function (oldVal, newVal) {
            if (this.isPlacesLoaded) {
                this.updateMap();
            }
        },
        '$route' (to, from) {
            this.isPlacesLoaded = false;

            this.$store.dispatch('place/fetchPlaces', to.query)
                .then(() => {
                    this.isPlacesLoaded = true;
                });
        }
    },
    computed: {
        ...mapState('place', ['places']),
        ...mapState('search', ['currentPosition', 'mapInitialized']),
        ...mapGetters('place', ['getFilteredByName']),
        ...mapGetters({
            user: 'auth/getAuthenticatedUser'
        }),

        currentCenter() {
            return {
                lat: this.currentPosition.latitude,
                lng: this.currentPosition.longitude
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
        position: sticky;
        position: -webkit-sticky;
        top: 3.75rem;
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