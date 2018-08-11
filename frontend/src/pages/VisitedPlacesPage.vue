<template>
    <div class="row">
        <div class="column">
            <div v-for="(visitedPlace,index) in visitedPlaces" :key="visitedPlace.id">
                <VisitedPlacesComponent :visitedPlace="visitedPlace" :index="index + 1"/>
            </div>
        </div>

        <div class="column mapbox-wrapper">
            <section id="map">
                <mapbox
                        :access-token="getMapboxToken"
                        :map-options="{style: getMapboxStyle}"
                        :fullscreen-control="{
                            show: true,
                            position: 'bottom-right'
                        }">
                </mapbox>
            </section>
        </div>
    </div>
</template>

<style lang="scss" scoped>
    .row {
        max-width: 1200px;
        margin-left: auto;
        margin-right: auto;
    }

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
</style>

<style>
    .mapboxgl-ctrl-top-left,
    .mapboxgl-ctrl-top-right {
        top: 50px;
    }
</style>

<script>
    import { mapGetters } from "vuex";
    import VisitedPlacesComponent from '../components/Places/VisitedPlacesComponent';
    import Mapbox from 'mapbox-gl-vue';

    export default {
        name: "VisitedPlacesPage",
        components: {
            VisitedPlacesComponent,
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
                        address: "ул. Толкиен, 3",
                        longitude: null,
                        latitude: null,
                        zip: null,
                        creator_id: null,
                        categories: {
                            id: 2,
                            name: 'Ресторан'
                        },
                        place_photo: {
                            url: "http://www.fraufluger.ru/files/images/story/a7ab21562ce4476d11936f0fd3c27fa6_560x416.jpg",
                            description: "Сказка",
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
                            place_name: "Сказка",
                            place_description: "Ох",
                            language_id: 2
                        },
                        cities: {
                            id: 12,
                            name: "Днепр"
                        }
                    },
                    {
                        id: 2,
                        ratings: {
                            rating: 8.8
                        },
                        address: "ул. Космос, 18",
                        longitude: null,
                        latitude: null,
                        zip: null,
                        creator_id: null,
                        categories: {
                            id: 10,
                            name: 'Ресторан'
                        },
                        place_photo: {
                            url: "https://www.stihi.ru/pics/2012/11/19/8139.jpg",
                            description: "Буржуй",
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
                            place_name: "Буржуй",
                            place_description: "Зверь",
                            language_id: 2
                        },
                        cities: {
                            id: 4,
                            name: "Одесса"
                        }
                    },
                    {
                        id: 3,
                        ratings: {
                            rating: 10
                        },
                        address: "ул. Р.Стонз, 62",
                        longitude: null,
                        latitude: null,
                        zip: null,
                        creator_id: null,
                        categories: {
                            id: 10,
                            name: 'Art Pub'
                        },
                        place_photo: {
                            url: "https://static1.squarespace.com/static/5523fa93e4b0b65a7c7d15b4/t/576050c5a3360c552edf9b4f/1465929930315/",
                            description: "Beer&Blues",
                            posted_at: '2018-08-08'
                        },
                        reviews: {

                        },
                        places_tr: {
                            id: 2,
                            place_name: "Beer&Blues",
                            place_description: "beer and blues",
                            language_id: 2
                        },
                        cities: {
                            id: 12,
                            name: "Киев"
                        }
                    },
                    {
                        id: 4,
                        ratings: {
                            rating: 6.3
                        },
                        address: "ул. Кошки, 43",
                        longitude: null,
                        latitude: null,
                        zip: null,
                        creator_id: null,
                        categories: {
                            id: 10,
                            name: 'Парк'
                        },
                        place_photo: {
                            url: "https://i.ytimg.com/vi/3lqlc-ooJpE/hqdefault.jpg",
                            description: "Чебуречек",
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
                            place_name: "Чебуречек",
                            place_description: "Чебуречек очень вкусный",
                            language_id: 2
                        },
                        cities: {
                            id: 10,
                            name: "Львов"
                        }
                    },
                ]
            }
        },
        computed: {
            ...mapGetters("map", ["getMapboxToken", "getMapboxStyle"])
        }
    }
</script>

