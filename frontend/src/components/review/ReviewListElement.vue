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
                        <div class="review-photos">
                            <img 
                                v-for="(photo, index) in review.photos"
                                :src="photo"
                                :key="index"
                                v-img="{ group: review.id}"
                            >
                        </div>
                    </template>

                    <LikeDislikeButtons
                        @like="onLikeReview"
                        @dislike="onDislikeReview"
                        @showUsersWhoLiked="onShowUsersWhoLiked"
                        @showUsersWhoDisliked="onShowUsersWhoDisliked"
                        :likes="review.likes"
                        :dislikes="review.dislikes"
                        :status="review.like"
                        font-size="0.5rem"
                        class="review-like"
                    />
                    <UsersWhoLikedDislikedReviewModals
                        :is-users-who-liked-review-modal-active="isUsersWhoLikedReviewModalActive"
                        :is-users-who-disliked-review-modal-active="isUsersWhoDislikedReviewModalActive"
                        @updateUsersWhoLikedReviewModalActive="updateUsersWhoLikedReviewModalActive"
                        @updateUsersWhoDislikedReviewModalActive="updateUsersWhoDislikedReviewModalActive"
                    />
                </div>
            </article>
        </div>
    </div>
</template>

<script>
import { mapActions } from 'vuex';
import LikeDislikeButtons from '@/components/misc/LikeDislikeButtons';
import UsersWhoLikedDislikedReviewModals from '@/components/review/UsersWhoLikedDislikedReviewModals';

export default {
    name: 'ReviewListElement',
    components: {
        LikeDislikeButtons,
        UsersWhoLikedDislikedReviewModals
    },
    props: {
        review: {
            type: Object,
            required: true
        }
    },

    data() {
        return {
            reviewImageUrl: '',
            isUsersWhoLikedReviewModalActive: false,
            isUsersWhoDislikedReviewModalActive: false
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
        ...mapActions('review', [
            'getReviewPhotos',
            'likeReview', 
            'dislikeReview',
            'getUsersWhoLikedReview',
            'getUsersWhoDislikedReview'
        ]),
        getReviewImage: function() {
            this.getReviewPhoto(this.review.id)
                .then((result) => {
                    this.reviewImageUrl = result;
                })
                .catch(() => {
                    this.reviewImageUrl = '';
                });
        },

        onLikeReview() {
            this.likeReview(this.review.id);
        },

        onDislikeReview() {
            this.dislikeReview(this.review.id);
        },

        onShowUsersWhoLiked() {
            if (this.review.likes) {
                this.getUsersWhoLikedReview(this.review.id)
                    .then( () => {
                        this.updateUsersWhoLikedReviewModalActive(true);
                    });
            }
        },

        onShowUsersWhoDisliked() {
            if (this.review.dislikes) {
                this.getUsersWhoDislikedReview(this.review.id)
                    .then( () => {
                        this.updateUsersWhoDislikedReviewModalActive(true);
                    });
            }
        },

        updateUsersWhoLikedReviewModalActive(newValue) {
            this.isUsersWhoLikedReviewModalActive = newValue;
        },

        updateUsersWhoDislikedReviewModalActive(newValue) {
            this.isUsersWhoDislikedReviewModalActive = newValue;
        }
    }
};
</script>

<style lang="scss" scoped>
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

    .review-photos {
        img {
            height: 150px;
            width: 150px;
        }
    }

    .review-like {
        max-width: 80px;
    }
</style>