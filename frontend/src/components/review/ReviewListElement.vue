<template>
    <div class="review-wrp">
        <div class="review">
            <article class="media">
                <figure class="media-left">
                    <p class="image is-32x32">
                        <img :src="review.user.avatar_url">
                    </p>
                </figure>
                <div class="media-content">
                    <div class="top-line">
                        <strong><a>{{ userName }}</a></strong>
                        <small>{{ date }}</small>
                    </div>
                    <div class="content">
                        <p>{{ review.description }}</p>
                    </div>

                    <template v-if="isImageAttached">
                        <div class="image is-3by1">
                            <img 
                                v-for="(photo, index) in this.review.photos" 
                                class="review-photo" 
                                :src="photo" 
                                :key="index"
                            >
                        </div>
                    </template>

                    <LikeDislikeButtons
                        @like="onLikeReview"
                        @dislike="onDislikeReview"
                        :likes="review.likes"
                        :dislikes="review.dislikes"
                        :status="review.like"
                        font-size="0.5rem"
                        class="review-like"
                    />
                </div>
            </article>
        </div>
    </div>
</template>

<script>
import { mapActions } from 'vuex';
import LikeDislikeButtons from '@/components/misc/LikeDislikeButtons';

export default {
    name: 'ReviewListElement',
    components: {LikeDislikeButtons},
    props: {
        review: {
            type: Object,
            required: true
        }
    },

    data() {
        return {
            reviewImageUrl: ''
        };
    },

    created() {
        this.getReviewPhotos(this.review.id);
    },

    computed: {
        userName() {
            return this.review.user.first_name + ' ' + this.review.user.last_name;
        },

        isImageAttached() {
            return this.review.photos.length;
        },
        date() {
            const date = new Date(this.review['created_at']);
            const options = {
                year: 'numeric',
                month: 'long',
                day: 'numeric',
                weekday: 'long',
            };
            return date.toLocaleString('en-US', options);
        }
    },

    methods: {
        ...mapActions('review', ['getReviewPhotos']),
        ...mapActions('review', ['likeReview', 'dislikeReview']),
        onLikeReview() {
            this.likeReview(this.review.id);
        },

        onDislikeReview() {
            this.dislikeReview(this.review.id);
        }
    }
};
</script>

<style scoped>
    .review-wrp {
        background: #fff;
        border-top: 1px solid #efeff4;
    }

    .review {
        padding: 15px;
    }

    .top-line {
        display: flex;
        flex-direction: row;
        justify-content: space-between;
    }

    /* for fill in the div without shrink */
    .review-photo {
        object-fit: cover;
    }

    .review-like {
        max-width: 80px;
    }
</style>