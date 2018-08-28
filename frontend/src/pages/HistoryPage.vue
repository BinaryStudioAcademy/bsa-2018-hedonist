<template>
    <div class="row">
        <div v-if="isPlacesLoaded" class="column visitedplaces-wrapper">
            <div
                v-for="(checkInId, index) in checkIns.allIds"
                :key="checkInId"
            >
                <PlaceVisitedPreview
                    :check-in="getCheckInById(checkInId)"
                    :check-in-place="getPlaceByCheckInId(checkInId)"
                    :timer="50 * (index+1)"
                />
            </div>
        </div>

        <div class="column mapbox-wrapper">
            <section id="map">
                <mapbox
                    :access-token="mapboxToken"
                    :map-options="{
                        style: mapboxStyle,
                    }"
                    :fullscreen-control="{
                        show: true,
                        position: 'bottom-right'
                    }"
                    @map-init="mapInitialize"
                />
            </section>
        </div>
    </div>
</template>

<script>
import {mapGetters, mapActions, mapState} from 'vuex';
import PlaceVisitedPreview from '../components/place/PlaceVisitedPreview';
import LocationService from '@/services/location/locationService';
import markerManager from '@/services/map/markerManager';
import Mapbox from 'mapbox-gl-vue';
import mapSettingsService from '@/services/map/mapSettingsService';

export default {
    name: 'HistoryPage',
    components: {
        PlaceVisitedPreview,
        Mapbox
    },
    data() {
        return {
            isPlacesLoaded: false,
            isMapLoaded: false,
            markerManager: null,
            userCoordinates: {
                lat: null,
                lng: null
            },
            mapboxToken: mapSettingsService.getMapboxToken(),
            mapboxStyle: mapSettingsService.getMapboxStyle()
        };
    },
    computed: {
        ...mapGetters('user/history', [
            'getCheckInById',
            'getPlaceById',
            'getPlaceByCheckInId',
            'placeList'
        ]),
        ...mapState('user/history', [
            'checkIns', 'places', 'currentLatitude', 'currentLongitude', 'mapInitialized'
        ]),
    },
    created() {
        this.loadUserCoords().then((coords) => {
            this.setCurrentMapCenter(coords);
        });
        this.loadCheckInPlaces()
            .then(() => {
                this.isPlacesLoaded = true;
                this.setCurrentMapCenter(
                    mapSettingsService.getMapboxCenter(this.places.byId, this.places.allIds)
                );
            })
            .catch((err) => {
                this.isPlacesLoaded = true;
            });
    },
    watch: {
        isMapLoaded: function (oldVal, newVal) {
            this.updateMap(this.placeList);
        },
        isPlacesLoaded: function (oldVal, newVal) {
            this.updateMap(this.placeList);
        }
    },
    methods: {
        ...
        mapActions('user/history', [
            'loadCheckInPlaces', 'setCurrentMapCenter', 'mapInitialization'
        ]),

        mapInitialize(map) {
            this.markerManager = markerManager.getService(map);
            this.isMapLoaded = true;
        }
        ,
        updateMap(places) {
            if(this.isMapLoaded && this.isPlacesLoaded) {
                this.markerManager.setMarkersFromPlacesAndFit(...places);
            }
        },
        loadUserCoords() {
            return new Promise((resolve, reject) => {
                LocationService.getUserLocationData()
                    .then(coordinates => {
                        this.userCoordinates.lat = coordinates.lat;
                        this.userCoordinates.lng = coordinates.lng;
                        resolve({
                            latitude: coordinates.lat,
                            longitude: coordinates.lng
                        });
                    });
            });
        }
        ,
    }
}
;

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

    #map {
        text-align: justify;
        position: fixed;
        top: 87px;
        bottom: 0;
        right: 0;
        width: 50%;
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

                #map {
                    position: absolute;
                    width: 100%;
                }
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
