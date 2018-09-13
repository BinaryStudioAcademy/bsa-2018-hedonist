<template>
    <transition name="fade">
        <div class="review-wrp" v-if="active">
            <div class="review">
                <article class="media">
                    <figure class="media-left">
                        <router-link :to="{ name: 'OtherUserPage', params: { id: review.user.id }}">
                            <div class="image avatar-wrp">
                                <img
                                    v-if="review.user.avatar_url"
                                    :src="review.user.avatar_url"
                                    class="avatar"
                                >
                                <img
                                    v-else
                                    src="/assets/add_review_default_avatar.png"
                                    class="avatar"
                                >
                            </div>
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
import { mapActions, mapGetters } from 'vuex';
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
            isUsersWhoLikedReviewModalActive: false,
            isUsersWhoDislikedReviewModalActive: false
        };
    },

    created() {
        setTimeout(() => {
            this.active = true;
        }, this.timer);

        Echo.private(`review.${this.review.id}`).listen('.attitude.set', (payload) => {
            this.$store.dispatch('review/handleAttitude', {
                reviewId: payload.reviewId,
                attitudeType: payload.attitudeType
            });
        });
    },

    computed: {
        ...mapGetters('auth',['getAuthenticatedUser']),
        userName() {
            return this.review.user.first_name + ' ' + this.review.user.last_name;
        },
        isImageAttached() {
            return this.review.photos.length;
        },
        canLikeOrDislike(){
            return this.review.user.id !== this.getAuthenticatedUser.id;
        },
        date() {
            const date = new Date(this.review['created_at']);
            const options = {
                year: 'numeric',
                month: 'long',
                day: 'numeric',
                weekday: 'long',
            };
            
            let locale = this.$i18n.locale();
            if (locale === 'ua') {
                locale = 'uk';
            }

            return date.toLocaleString(locale, options);
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

        onLikeReview() {
            if(!this.canLikeOrDislike){
                this.showLikeDislikeOwnReviewToast();
                return;
            }
            this.likeReview(this.review.id);
        },

        onDislikeReview() {
            if(!this.canLikeOrDislike){
                this.showLikeDislikeOwnReviewToast();
                return;
            }
            this.dislikeReview(this.review.id);
        },

        showLikeDislikeOwnReviewToast(){
            this.$toast.open({
                message: this.$t('place_page.message.like_own_review'),
                type:'is-danger'
            });
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
    .avatar-wrp {
        width: 32px;
        height: 32px;

        .avatar {
            border-radius:4px;
            width: 100%;
            height: 100%;
            object-fit: cover;
            object-position: 50% 50%;
        }
    }

    .fade-enter-active, .fade-leave-active {
        transition: opacity .5s;
    }

    .fade-enter, .fade-leave-to {
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