<template>
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
            <h2 class="title">{{ index }}.{{ visitedPlace.places_tr.place_name }}</h2>
            <p>{{ visitedPlace.address }}, {{ visitedPlace.cities.name }}</p>
            <p>{{ visitedPlace.categories.name }} - Подсказок и отзывов: </p>

            <button class="saved"><i class="fa fa-bookmark"></i>Сохранено</button>
        </div>
    </article>
</template>

<style lang="scss" scoped>

    article {
        margin: 1.5rem 3rem;
        text-align: left;
    }

    .entry-media {
        height: 300px;
        width: 400px;
    }

    .image {
        margin: 0 auto;
        max-width: 400px;
        max-height: 300px;
    }

    .item-description {
        .rating-wrapper {
            float: right;
        }

        p {
            padding-left: 0.5rem;
        }

        .saved {
            padding-top: 0.3rem;
            padding-bottom: 0.3rem;
            margin-top: 2rem;

            i {
                padding-right: 0.6rem;
                color: #00E676;
            }
        }
    }

    .title {
        margin-top: 1.5rem;
        padding-left: 0.5rem;
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
            },
            index: {
                type: Number
            }
        }
    }
</script>