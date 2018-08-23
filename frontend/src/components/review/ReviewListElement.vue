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
                        <small><a>21 September 2018</a></small>
                    </div>
                    <div class="content">
                        <p>{{ review.description }}</p>
                    </div>
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
import { mapActions, mapState } from 'vuex';
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
    methods: {
        ...mapActions('place', ['likeReview', 'dislikeReview']),
        onLikeReview() {
            this.likeReview(this.review.id);
        },
        onDislikeReview() {
            this.dislikeReview(this.review.id);
        }
    },
    computed: {
        ...mapState('place', ['currentPlaceReviews']),
        userName() {
            return this.review.user.first_name + ' ' + this.review.user.last_name;
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

    .review-like {
        max-width: 80px;
    }
</style>