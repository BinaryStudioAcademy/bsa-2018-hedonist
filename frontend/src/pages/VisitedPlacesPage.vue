<template>
    <section class="container">
        <div v-for="(visitedPlace,index) in visitedPlaces" :key="visitedPlace.id">
            <VisitedPlacesComponent :visitedPlace="visitedPlace" :index="index + 1"/>
        </div>
    </section>
</template>

<style lang="scss" scoped>
    .container {
        display: flex;
        flex-wrap: nowrap;
    }
</style>

<script>
    import VisitedPlacesComponent from '../components/Places/VisitedPlacesComponent';

    export default {
        name: "VisitedPlacesPage",
        data() {
            return {
                visitedPlaces: [
                    {
                        id: 1,
                        ratings: {
                            rating: 10
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
                        reviews: {

                        },
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
                    {
                        id: 2,
                        rating: 10,
                        address: "вул. Кошки, 43",
                        longitude: null,
                        latitude: null,
                        zip: null,
                        creator_id: null,
                        category_id: 1,
                        place_photo: {
                            url: "https://media4.designs.net/images/hero_illustration_left.png",
                            description: "Ч12ебуречек",
                            posted_at: '2018-08-08'
                        },
                        reviews: {

                        },
                        places_tr: {
                            id: 3,
                            place_name: "Буржуй",
                            place_description: "Чё?",
                            language_id: 2
                        }
                    },
                    {
                        id: 3,
                        rating: 10,
                        address: "вул. Кошки, 43",
                        longitude: null,
                        latitude: null,
                        zip: null,
                        creator_id: null,
                        category_id: 1,
                        place_photo: {
                            url: "https://media4.designs.net/images/hero_illustration_left.png",
                            description: "Ч1241ебуречек",
                            posted_at: '2018-08-08'
                        },
                        reviews: {

                        },
                        places_tr: {
                            id: 3,
                            place_name: "Буржуй",
                            place_description: "Чё?",
                            language_id: 2
                        }
                    }
                ]
            }
        },
        components: {VisitedPlacesComponent},
    }
</script>

