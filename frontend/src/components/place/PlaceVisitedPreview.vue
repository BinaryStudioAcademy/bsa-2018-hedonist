<template>
    <transition name="slide-fade">
        <article v-if="active">
            <div class="entry-media">
                <img
                    class="image"
                    :src="placePhoto"
                >
            </div>
            <div class="item-description">
                <div class="rating-wrapper">
                    <div class="rating">
                        {{ checkInPlace.rating }}
                    </div>
                </div>
                <h2 class="title">
                    <router-link :to="`/places/${checkIn.id}`">
                        {{ placeName }}
                    </router-link>
                </h2>
                <p>{{ checkInPlace.city.name }}</p>
                <p>{{ checkInPlace.category.name }}</p>

                <button class="saved"><i class="fa fa-bookmark" />Saved</button>
            </div>
        </article>
    </transition>
</template>

<script>
import imageStub from '@/assets/no-photo.png';

export default {
    name: 'PlaceVisitedPreview',
    data() {
        return {
            active: false,
            placePreviewMock: imageStub
        };
    },
    props: {
        checkIn: {
            required: true,
            type: Object,
        },
        checkInPlace: {
            required: true,
            type: Object,
        },
        timer: {
            required: true,
            type: Number
        }
    },
    created() {
        setTimeout(() => {
            this.active = true;
        }, this.timer);
    },
    computed: {
        placeName() {
            return this.checkInPlace.localization[0].name;
        },
        placePhoto() {
            return this.checkInPlace.photos[0].imgUrl || this.placePreviewMock;
        },
    }
};
</script>

<style lang="scss" scoped>

    article {
        margin: 1.5rem auto;
        text-align: left;
        width: 600px;
        background-color: #FFF;
    }

    .image {
        margin: 0 auto;
        max-width: 400px;
        max-height: 300px;
    }

    .item-description {
        margin-left: 0.5rem;
        margin-right: 0.5rem;

        .rating-wrapper {
            float: right;
        }

        p {
            padding-left: 0.5rem;
        }

        .saved {
            padding-top: 0.3rem;
            padding-bottom: 0.3rem;
            margin-top: 1rem;
            margin-bottom: 1rem;

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

    .slide-fade-enter-active {
        transition: all 0.5s ease;
    }

    .slide-fade-enter, .slide-fade-leave-to {
        transform: translateX(300px);
        opacity: 0;
    }

    @media screen and (max-width: 769px) {
        article, .entry-media {
            width: 100%;
        }
        .image {
            max-width: 90%;
        }
    }
</style>
