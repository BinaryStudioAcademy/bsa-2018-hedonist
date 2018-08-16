<template>
    <div class="row">
        <div class="column visitedplaces-wrapper">
            <div 
                v-for="(visitedPlace,index) in visitedPlaces" 
                :key="visitedPlace.id"
            >
                <PlaceVisitedPreview 
                    :visited-place="visitedPlace" 
                    :index="index + 1" 
                    :timer="50 * (index+1)"
                />
            </div>
        </div>

        <div class="column mapbox-wrapper">
            <section id="map">
                <mapbox
                    @map-load="mapLoaded"
                    :access-token="getMapboxToken"
                    :map-options="{
                        style: getMapboxStyle,
                        center: getMapboxCenter(),
                        zoom: 5
                    }"
                    :fullscreen-control="{
                        show: true,
                        position: 'bottom-right'
                    }"
                />
            </section>
        </div>
    </div>
</template>

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
        top: 0;
        bottom: 0;
        right: 0;
        width: 50%;
    }

    @media screen and (max-width: 769px) {
        .row {
            flex-direction: column;

            .mapbox-wrapper {
                position: relative;

                #map {
                    position: absolute;
                    width: 100%;
                    height: 500px;
                }
            }
        }
        .column {
            flex: 100%;
        }
    }
</style>

<style>
    .mapboxgl-ctrl-top-left,
    .mapboxgl-ctrl-top-right {
        top: 50px;
    }
</style>

<script>
import { mapGetters } from 'vuex';
import PlaceVisitedPreview from '../components/place/PlaceVisitedPreview';
import Mapbox from 'mapbox-gl-vue';
import mapActions from '../store/modules/map/actions';

export default {
    name: 'HistoryPage',
    components: {
        PlaceVisitedPreview,
        Mapbox
    },
    data() {
        return {
            visitedPlaces: [
                {
                    id: 1,
                    ratings: {
                        rating: 7.9
                    },
                    address: 'Tolkien str., 3',
                    latitude: 48.424234,
                    longitude: 34.974195,
                    zip: null,
                    creator_id: null,
                    categories: {
                        id: 2,
                        name: 'Restaurant'
                    },
                    place_photo: {
                        url: 'http://www.fraufluger.ru/files/images/story/a7ab21562ce4476d11936f0fd3c27fa6_560x416.jpg',
                        description: 'Сказка',
                        posted_at: '2018-08-08'
                    },
                    reviews: [
                        {
                            id: 1,
                            rate: 2
                        },
                        {
                            id: 2,
                            rate: 2
                        },
                        {
                            id: 3,
                            rate: 2
                        }
                    ],
                    places_tr: {
                        id: 2,
                        place_name: 'Fairy tale',
                        place_description: 'Ох',
                        language_id: 2
                    },
                    cities: {
                        id: 12,
                        name: 'Dnepr'
                    }
                },
                {
                    id: 2,
                    ratings: {
                        rating: 8.8
                    },
                    address: 'Cosmos str., 18',
                    latitude: 46.423080,
                    longitude: 30.756138,
                    zip: null,
                    creator_id: null,
                    categories: {
                        id: 10,
                        name: 'Restaurant'
                    },
                    place_photo: {
                        url: 'https://www.stihi.ru/pics/2012/11/19/8139.jpg',
                        description: 'Bourgeois',
                        posted_at: '2018-08-08'
                    },
                    reviews: [
                        {
                            id: 1,
                            rate: 2
                        }
                    ],
                    places_tr: {
                        id: 2,
                        place_name: 'Bourgeois',
                        place_description: 'Beast',
                        language_id: 2
                    },
                    cities: {
                        id: 4,
                        name: 'Odesa'
                    }
                },
                {
                    id: 3,
                    ratings: {
                        rating: 10
                    },
                    address: 'ул. Р.Стонз, 62',
                    latitude: 50.486555,
                    longitude: 30.329787,
                    zip: null,
                    creator_id: null,
                    categories: {
                        id: 10,
                        name: 'Art Pub'
                    },
                    place_photo: {
                        url: 'https://static1.squarespace.com/static/5523fa93e4b0b65a7c7d15b4/t/576050c5a3360c552edf9b4f/1465929930315/',
                        description: 'Beer&Blues',
                        posted_at: '2018-08-08'
                    },
                    reviews: {

                    },
                    places_tr: {
                        id: 2,
                        place_name: 'Beer&Blues',
                        place_description: 'beer and blues',
                        language_id: 2
                    },
                    cities: {
                        id: 12,
                        name: 'Kiev'
                    }
                },
                {
                    id: 4,
                    ratings: {
                        rating: 6.3
                    },
                    address: 'Cat str., 43',
                    latitude: 49.817136,
                    longitude: 24.005504,
                    zip: null,
                    creator_id: null,
                    categories: {
                        id: 10,
                        name: 'Park'
                    },
                    place_photo: {
                        url: 'https://i.ytimg.com/vi/3lqlc-ooJpE/hqdefault.jpg',
                        description: 'Cheburek',
                        posted_at: '2018-08-08'
                    },
                    reviews: [
                        {
                            id: 1,
                            rate: 2
                        },
                        {
                            id: 2,
                            rate: 2
                        },
                        {
                            id: 3,
                            rate: 2
                        }
                    ],
                    places_tr: {
                        id: 2,
                        place_name: 'Cheburek',
                        place_description: 'Cheburek is delicious',
                        language_id: 2
                    },
                    cities: {
                        id: 10,
                        name: 'Lviv'
                    }
                },
            ]
        };
    },
    computed: {
        ...mapGetters('map', ['getMapboxToken', 'getMapboxStyle'])
    },
    methods: {
        mapLoaded: function (map) {
            map.addLayer({
                'id': 'points',
                'type': 'symbol',
                'source': {
                    'type': 'geojson',
                    'data': {
                        'type': 'FeatureCollection',
                        'features': this.generateMapFeatures()
                    }
                },
                'layout': {
                    'icon-image': '{icon}-15',
                    'text-field': '{title}',
                    'text-font': ['Open Sans Semibold', 'Arial Unicode MS Bold'],
                    'text-offset': [0, 0.6],
                    'text-anchor': 'top'
                }
            });
        },
        generateMapFeatures: function () {
            let features = [];
            this.visitedPlaces.forEach(function (place, i) {

                let feature = {
                    'type' : 'Feature',
                    'geometry' : {
                        'type' : 'Point',
                        'coordinates' : [place.longitude, place.latitude]
                    },
                    'properties' : {
                        'title' : place.places_tr.place_name,
                        'icon' : 'marker',
                        'marker-symbol' : i + 1
                    }
                };

                features.push(feature);
            });

            return features;
        },
        getMapboxCenter: function() {
            return mapActions.getMapboxCenter(this.visitedPlaces);
        }
    }
};

</script>

