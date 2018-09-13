<template>
    <transition name="slide-fade">
        <div class="container place-item" v-if="active">
            <div class="media">
                <figure v-if="hasPhotos" class="media-left image is-64x64">
                    <img
                        v-for="(photo, index) in place.photos"
                        v-img="{group: place.id}"
                        v-show="index === 0"
                        :src="photo.img_url"
                        :key="photo.id"
                        class="place-photo"
                    >
                </figure>
                <figure v-else class="media-left image is-64x64">
                    <img :src="notFoundPhoto" class="place-photo">
                </figure>
                <div class="media-content">
                    <h3
                        class="title is-6 has-text-primary"
                    >
                        <router-link :to="`/places/${place.id}`">
                            {{ localizedName }}
                        </router-link>
                    </h3>
                    <p class="place-city"><strong>{{ place.city.name }}</strong></p>
                    <p class="place-category">{{ place.category.name }}</p>
                    <p class="address">{{ place.address }}</p>
                </div>
                <div class="media-right rating-wrapper">
                    <PlaceRating
                        v-if="place.rating"
                        :value="Number(place.rating)"
                    />
                </div>
            </div>
            <div class="media">
                <div class="media-content">
                    <b-taglist>
                        <b-tag
                            type="is-info"
                            v-for="tag in place.tags"
                            :key="tag.id"
                            class="preview-tag"
                        >
                            {{ tag.name }}
                        </b-tag>
                    </b-taglist>
                </div>
            </div>
            <Review
                v-if="place.review && showReview"
                :review="place.review"
                :show-like-dislike-btns="false"
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
        },
        showReview: {
            default: true,
            type: Boolean,
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
                message: this.$t('place_page.message.review_like'),
                type: 'is-info',
                position: 'is-bottom'
            });
        },
        dislike() {
            this.$toast.open({
                message: this.$t('place_page.message.review_dislike'),
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
        margin-bottom: 0.5rem;
        padding: 10px;
        font-size: 0.75rem;
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

    .media + .media {
        margin-top: 0.25rem;
        padding-top: 0.25rem;
    }

    .media-right {
        grid-area: media-right;
    }

    .media-left {
        grid-area: media-left;

        .place-photo {
            width: 100%;
            height: 100%;
            object-fit: cover;
            object-position: 50% 50%;
        }
    }

    .preview-tag {
        font-size: 0.75em;
    }

    .media-content {
        grid-area: media-content;
        .address {
            word-break: break-all;
        }
    }
</style>