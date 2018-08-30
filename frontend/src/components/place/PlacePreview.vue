<template>
    <transition name="slide-fade">
        <div class="container place-item" v-if="active">
            <div class="media">
                <figure v-if="hasPhotos" class="media-left image is-128x128">
                    <img 
                        v-for="(photo, index) in place.photos"
                        v-img="{group: place.id}"
                        v-show="index === 0"
                        :src="photo.img_url"
                        :key="photo.id"
                    >
                </figure>
                <figure v-else class="media-left image is-128x128">
                    <img :src="notFoundPhoto">
                </figure>
                <div class="media-content">
                    <h3
                        class="title has-text-primary"
                    >
                        <router-link :to="`/places/${place.id}`">
                            {{ localizedName }}
                        </router-link>
                    </h3>
                    <p class="place-city"><strong>{{ place.city.name }}</strong></p>
                    <p class="place-category">
                        <a href="#">{{ place.category.name }}</a>
                    </p>
                    <p class="address">
                        {{ place.address }}
                    </p>
                </div>
                <div class="media-right rating-wrapper">
                    <PlaceRating
                        v-if="place.rating"
                        :value="Number(place.rating)"
                        :show-rating="false"
                        :rating-count="place.ratingCount"
                    />
                </div>
            </div>
            <div class="media">
                <div class="media-content">
                    <b-taglist>
                        <b-tag
                            type="is-info"
                            v-for="tag in place.category.tags"
                            :key="tag.id"
                        >
                            {{ tag.name }}
                        </b-tag>
                    </b-taglist>
                </div>
            </div>
            <Review
                v-if="place.review"
                :review="place.review"
            />
        </div>
    </transition>
</template>

<script>
import Review from '@/components/review/PlacePreviewReviewItem';
import imagePlaceholder from '@/assets/placeholder_128x128.png';
import PlaceRating from './PlaceRating';

export default {
    name: 'PlacePreview',
    components: {
        Review,
        PlaceRating,
    },
    data() {
        return {
            active: false
        };
    },
    props: {
        place: {
            required: true,
            type: Object,
        },
        timer: {
            required: true,
            type: Number,
        }
    },
    computed: {
        localizedName(){
            return this.place.localization[0].name;
        },
        hasPhotos() {
            return this.place.photos !== undefined && this.place.photos.length;
        },
        notFoundPhoto() {
            return imagePlaceholder;
        },
    },
    methods: {
        like() {
            this.$toast.open({
                message: 'You liked this review!',
                type: 'is-info',
                position: 'is-bottom'
            });
        },
        dislike() {
            this.$toast.open({
                message: 'You disliked this review',
                position: 'is-bottom',
                type: 'is-info'
            });
        }
    },
    created() {
        setTimeout(() => {
            this.active = true;
        }, this.timer);
    }
};
</script>

<style lang="scss" scoped>
    .place-item {
        background: #FFF;
        color: grey;
        max-width: 100%;
        margin-bottom: 1rem;
        padding: 10px;
    }

    .columns {
        width: 100%;
        margin: 0;
    }

    .title {
        margin-bottom: 0.5rem;
    }

    .image > img {
        border-radius: 5px;
    }

    .place-category {
        margin-bottom: 0.25rem;
        a {
            color: grey;
            -webkit-transition: color 0.3s;
            -moz-transition: color 0.3s;
            -ms-transition: color 0.3s;
            -o-transition: color 0.3s;
            transition: color 0.3s;

            &:hover {
                color: black;
                text-decoration: underline;
            }
        }
    }

    .address {
        margin-bottom: 0.5rem;
    }

    hr {
        color: grey;
        border-width: 3px;
    }

    .slide-fade-enter-active {
        transition: all 0.5s ease;
    }

    .slide-fade-enter, .slide-fade-leave-to {
        transform: translateX(300px);
        opacity: 0;
    }

</style>