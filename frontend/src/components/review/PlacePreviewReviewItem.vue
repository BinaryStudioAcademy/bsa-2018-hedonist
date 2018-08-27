<template>
    <div class="media review-wrapper">
        <figure class="image is-32x32 media-left">
            <img :src="review.user.avatar_url" class="user-avatar">
        </figure>
        <div class="media-content">
            <div class="review-title">
                <a href="#" class="has-text-primary review-username">
                    {{ this.userName }}
                </a>
                •
                <span class="review-date">
                    {{ review.created_at }}
                </span>
            </div>
            <div class="review-text">
                {{ review.description }}
            </div>
            <LikeDislikeButton
                font-size="0.7rem"
                @like="onLikeReview"
                @dislike="onDislikeReview"
                @showUsersWhoLiked="onShowUsersWhoLiked"
                @showUsersWhoDisliked="onShowUsersWhoDisliked"
                :likes="review.likes"
                :dislikes="review.dislikes"
                :status="review.like"
                class="review-likes"
            />
        </div>
    </div>
</template>

<script>
import { mapActions, mapMutations, mapState } from 'vuex';
import LikeDislikeButton from '@/components/misc/LikeDislikeButtons';

export default {
    name: 'PlacePreviewReviewItem',
    components: {LikeDislikeButton},
    props: {
        review: {
            type: Object,
            required: true
        }
    },
    computed:{
        userName() {
            return this.review.user.first_name + ' ' + this.review.user.last_name;
        },

        ...mapState('review', {
            usersWhoLikedReview: 'usersWhoLikedReview',
            usersWhoDislikedReview: 'usersWhoDislikedReview'
        })
    },
    methods: {
        ...mapActions('review', [
            'likeReviewSearch',
            'dislikeReviewSearch',
            'getUsersWhoLikedReview',
            'getUsersWhoDislikedReview'
        ]),
        ...mapMutations('place', {
            updateReviewLikedState: 'UPDATE_REVIEW_LIKED_STATE',
            updateReviewDislikedState: 'UPDATE_REVIEW_DISLIKED_STATE'
        }),

        onLikeReview() {
            this.likeReviewSearch(this.review.id)
                .then( () => {
                    this.updateReviewLikedState(this.review.id);
                });
        },

        onDislikeReview() {
            this.dislikeReviewSearch(this.review.id)
                .then( () => {
                    this.updateReviewDislikedState(this.review.id);
                });
        },

        onShowUsersWhoLiked() {
            if (this.review.likes) {
                this.getUsersWhoLikedReview(this.review.id)
                    .then( () => {
                        
                    });
            }
        },

        onShowUsersWhoDisliked() {
            if (this.review.dislikes) {
                this.getUsersWhoDislikedReview(this.review.id)
                    .then( () => {
                        
                    });
            }
        }
    }
};
</script>

<style lang="scss" scoped>
    .user-avatar {
        border-radius: 5px;
    }

    .review-date, .review-text {
        color: grey;
    }

    .review-likes {
        align-self: flex-start;
        width: 100px;
    }

    .review-username {
        font-weight: bolder;
        font-size:1.2rem;
    }

</style>
