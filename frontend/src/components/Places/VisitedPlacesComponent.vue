<template>
    <div class="container place-item">

        <article>
            <div class="entry-media">
                <img class="image" :src="visitedPlace.place_photo.url"/>
            </div>
            <div class="item-description">
                <div class="rating-wrapper">
                    <div class="rating">
                        {{visitedPlace.ratings.rating}}
                    </div>
                </div>
                <h2 class="title">{{ visitedPlace.places_tr.place_name }}</h2>
                <p>{{ visitedPlace.address }}, {{ visitedPlace.cities.name }}</p>
                <p>{{ visitedPlace.categories.name }} - Подсказок и отзывов: </p>

                <button class="saved" disabled><i class="fa fa-star"></i>Сохранено</button>
            </div>
        </article>

    </div>
</template>

<style lang="scss" scoped>
    .container {
        display: flex;
        flex-wrap: nowrap;
    }

    article {
        margin: 0.5rem;
        text-align: left;
    }

    .image {
        margin: 0 auto;
        max-width: 400px;
    }

    .item-description {
        .rating-wrapper {
            float: right;
        }

        p {
            padding-left: 0.5rem;
        }

        .saved {
            margin-top: 2rem;
        }
    }

    .title {
        padding-top: 0.4rem;
        padding-left: 0.5rem;
    }

    .rating-wrapper {
        margin-top: 1.5rem;
    }
    .rating {
        width: 48px;
        height: 48px;
        background: #00E676;
        border-radius: 7px;
        margin: auto;
        line-height: 48px;
        font-size: 1.5rem;
        color: #FFF;
        text-align: center;
    }
</style>

<script>
    export default {
        name: "VisitedPlacesComponent",
        props: {
            visitedPlace: {
                required: true,
                type: Object,
            }
        }
    }
</script>