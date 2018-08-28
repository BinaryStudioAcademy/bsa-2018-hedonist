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
                    <PlaceRating :value="Number(checkInPlace.rating)" />
                </div>
                <h2 class="title">
                    <router-link :to="`/places/${checkIn.id}`">
                        {{ placeName }}
                    </router-link>
                </h2>
                <div>
                    <strong>{{ checkInPlace.city.name }}</strong>
                </div>
                <div>
                    <a class="link" role="link">{{ checkInPlace.category.name }}</a>
                </div>
            </div>
        </article>
    </transition>
</template>

<script>
import imageStub from '@/assets/no-photo.png';
import PlaceRating from './PlaceRating';

export default {
    name: 'PlaceVisitedPreview',
    components: {
        PlaceRating,
    },
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
        margin-bottom: 10px;
        padding: 10px;
        text-align: left;
        background-color: #FFF;
    }

    .link {
        color: grey;
        -webkit-transition: color 0.3s;
        transition: color 0.3s;

        &:hover {
            color: black;
            text-decoration: underline;
        }
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
