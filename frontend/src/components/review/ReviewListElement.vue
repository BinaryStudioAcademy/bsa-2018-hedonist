<template>
    <transition name="slide-fade">
        <div class="review-wrp" v-if="active">
            <div class="review">
                <article class="media">
                    <figure class="media-left">
                        <router-link :to="{ name: 'OtherUserPage', params: { id: review.user.id }}">
                            <p class="image is-32x32">
                                <img v-if="review.user.avatar_url" :src="review.user.avatar_url">
                                <img
                                    v-else
                                    src="/assets/add_review_default_avatar.png"
                                    height="32"
                                    width="32"
                                >
                            </p>
                        </router-link>
                    </figure>
                    <div class="media-content">
                        <div class="top-line">
                            <router-link :to="{ name: 'OtherUserPage', params: { id: review.user.id }}">
                                <strong>{{ userName }}</strong>
                            </router-link>
                            <small>{{ date }}</small>
                        </div>
                        <div class="content">
                            <p>{{ review.description }}</p>
                        </div>

                        <template v-if="isImageAttached">
                            <div class="review-photos">
                                <div
                                    class="review-image"
                                    v-for="(photo, index) in review.photos"
                                    :key="index"
                                >
                                    <img
                                        :src="photo"
                                        v-img="{ group: review.id}"
                                    >
                                </div>
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
    </transition>
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
        },
        timer: {
            required: true,
            type: Number,
        },
        isSorting: {
            type: Boolean,
            required: true
        }
    },

    data() {
        return {
            active: false,
            reviewImageUrl: '',
            isUsersWhoLikedReviewModalActive: false,
            isUsersWhoDislikedReviewModalActive: false
        };
    },

    created() {
        this.getReviewPhotos(this.review.id);
        setTimeout(() => {
            this.active = true;
        }, this.timer);
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

    watch: {
        isSorting: function() {
            this.getReviewPhotos(this.review.id);
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
    .slide-fade-enter-active {
        transition: all 0.5s ease;
    }

    .slide-fade-enter, .slide-fade-leave-to {
        transform: translateX(-300px);
        opacity: 0;
    }

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
        display: inline-flex;
    }

    .review-image {
        width: 180px;
        height: 128px;
        flex-shrink: 0;
        padding: 5px;

        img {
            width: 100%;
            height: 100%;
            object-fit: cover;
            object-position: 50% 50%;

            &:not(:last-child) {
                margin-right: 15px;
            }
        }
    }

    .review-like {
        max-width: 80px;
    }
</style>