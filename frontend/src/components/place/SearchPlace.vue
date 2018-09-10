<template>
    <section class="columns">
        <Preloader :active="isLoading" />
        <section class="column is-one-third-widescreen is-half-desktop">
            <SearchFilterPlace :is-places-loaded="!isLoading" />
            <CategoryTagsContainer
                v-if="placeCategory.id"
                @onSelectTag="onSelectTag"
            />
            <SpecialFeaturesFilter
                @onSelectFeature="onSelectFeature"
            />
            <div
                v-infinite-scroll="loadMore"
                :infinite-scroll-disabled="scrollBusy"
            >
                <template v-if="places.length">
                    <template v-for="(place, index) in places">
                        <PlacePreview
                            v-if="!isLoading"
                            :key="place.id"
                            :place="place"
                            :timer="50 * (index+1)"
                        />
                    </template>
                </template>
                <template v-else>
                    <div class="no-results">
                        <div class="no-results__title has-text-weight-bold">{{ $t('search.no_results') }}</div>

                        <div class="no-results__try">{{ $t('search.may_try') }}:</div>
                        <ul>
                            <li>{{ $t('search.removing_your_filters') }}</li>
                            <li>{{ $t('search.search_in_different_location') }}</li>
                            <li>{{ $t('search.search_for_something_more_general') }}</li>
                        </ul>
                    </div>
                </template>
            </div>
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
import {mapState, mapGetters, mapActions, mapMutations} from 'vuex';
import PlacePreview from './PlacePreview';
import Mapbox from 'mapbox-gl-vue';
import MapboxDraw from '@mapbox/mapbox-gl-draw';
import SearchFilterPlace from './SearchFilterPlace';
import LocationService from '@/services/location/locationService';
import markerManager from '@/services/map/markerManager';
import placeholderImg from '@/assets/placeholder_128x128.png';
import mapSettingsService from '@/services/map/mapSettingsService';
import infiniteScroll from 'vue-infinite-scroll';
import CategoryTagsContainer from './CategoryTagsContainer';
import SpecialFeaturesFilter from './SpecialFeaturesFilter';
import Preloader from '@/components/misc/Preloader';

export default {
    name: 'SearchPlace',
    components: {
        PlacePreview,
        Mapbox,
        SearchFilterPlace,
        CategoryTagsContainer,
        SpecialFeaturesFilter,
        Preloader
    },
    directives: {
        infiniteScroll
    },
    data() {
        return {
            filterQuery: '',
            isMapLoaded: false,
            map: {},
            markerManager: null,
            mapboxToken: mapSettingsService.getMapboxToken(),
            mapboxStyle: mapSettingsService.getMapboxStyle(),
            draw: {},
            currentPage: 1,
            scrollBusy: false
        };
    },
    created() {
        this.$store.dispatch('search/updateStateFromQuery', this.$route.query)
            .then(() => {
                this.$store.dispatch('search/updateQueryFilters');
                this.$store.dispatch('features/fetchAllFeatures');
            });
    },
    methods: {
        ...mapActions('search', [
            'setCurrentPosition',
            'mapInitialization',
            'updateStateFromQuery',
            'setLoadingState',
            'addSelectedTag',
            'deleteSelectedTag',
            'addSelectedFeature',
            'deleteSelectedFeature',
            'updateQueryFilters'
        ]),
        ...mapActions('category',['fetchCategoryTags']),

        mapInitialize(map) {
            if (this.mapInitialized) {
                return;
            }

            this.map = map;
            if (!this.$route.query.location)
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
        jumpTo(coordinates, zoom) {
            this.map.jumpTo({
                center: coordinates,
                zoom: zoom
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
            if (this.isMapLoaded && !this.isLoading) {
                this.markerManager.setMarkersFromPlacesAndFit(...this.places);
                if (this.$route.query.location && this.places.length > 0) {
                    let location = this.$route.query.location;
                    this.jumpTo(location.split(','), 11);
                }
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
        getQuery() {
            let data = this.draw.getAll();
            let query = this.$route.query;
            if (data.features.length > 0) {
                query.polygon = data.features.map(item => item.geometry.coordinates[0]);
            }
            return query;
        },
        updateSearchArea() {
            let query = this.getQuery();
            this.setLoadingState(true);
            this.$store.dispatch('place/fetchPlaces', query)
                .then(() => {
                    this.setLoadingState(false);
                    this.draw.deleteAll();
                });
        },
        loadMore: function () {
            if (this.isMapLoaded && !this.isLoading) {
                let query = this.getQuery();
                this.scrollBusy = true;
                this.currentPage++;
                this.$store.dispatch('place/loadMorePlaces', {
                    filters: this.$route.query,
                    page: this.currentPage
                })
                    .then(() => {
                        this.scrollBusy = false;
                        this.updateMap();
                    });
            }
        },
        onSelectTag(tagId, isTagActive) {
            if (isTagActive) {
                this.addSelectedTag(tagId);
            } else {
                this.deleteSelectedTag(tagId);
            }
            this.updateQueryFilters();
        },
        onSelectFeature(featureId, isFeatureActive) {
            if (isFeatureActive) {
                this.addSelectedFeature(featureId);
            } else {
                this.deleteSelectedFeature(featureId);
            }
            this.updateQueryFilters();
        },
    },
    watch: {
        isMapLoaded: function (oldVal, newVal) {
            if (!this.isLoading) {
                this.updateMap();
            }
        },
        isLoading: function (oldVal, newVal) {
            if (!this.isLoading) {
                this.updateMap();
            }
        }
    },
    computed: {
        ...mapState('place', ['places']),
        ...mapState('search', [
            'currentPosition',
            'mapInitialized',
            'isLoading',
            'placeCategory'
        ]),
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

    .mapboxgl-popup-close-button {
        font-size: 22px;
    }

    .link-place:hover {
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
        width: 66%;
    }

    .no-results {
        padding: 30px 50px;

        &__title {
            margin-bottom: 20px;
        }
        &__try {
            font-weight: 500;
        }

        ul {
            margin-left: 20px;

            li {
                font-size: 0.9rem;
                list-style: disc;
            }
        }
    }

    @media screen and (max-width: 1279px) {
        #map {
            width: 49%;
        }
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