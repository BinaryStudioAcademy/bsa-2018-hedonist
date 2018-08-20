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
                    <nav class="level">
                        <div class="level-left">
                            <a class="level-item" :class="{ liked: liked }">
                                <span class="icon is-small" @click="onLikeReview"><i class="far fa-thumbs-up" /></span>
                                <span class="is-size-6">{{ review.likes }}</span>
                            </a>
                            <a class="level-item" :class="{ disliked: disliked }">
                                <span class="icon is-small" @click="onDislikeReview"><i class="far fa-thumbs-down" /></span>
                                <span class="is-size-6">{{ review.dislikes }}</span>
                            </a>
                        </div>
                    </nav>
                </div>
            </article>
        </div>
    </div>
</template>

<script>
import { mapActions } from 'vuex';

export default {
    name: 'ReviewListElement',
    props: {
        review: {
            type: Object,
            required: true
        }
    },
    methods: {
        ...mapActions('place', ['likeReview', 'dislikeReview']),
        onLikeReview() {
            this.likeReview(this.review).then((res) => {
                this.onSuccess('You liked review');
            }).catch((res) => {
                this.onError('Review like error');
            });
        },
        onDislikeReview() {
            this.dislikeReview(this.review).then((res) => {
                this.onSuccess('You disliked review');
            }).catch((res) => {
                this.onError('Review dislike error');
            });
        },
        onError(error) {
            this.$toast.open({
                message: error,
                type: 'is-danger'
            });
        },
        onSuccess(success) {
            this.$toast.open({
                message: success,
                type: 'is-success'
            });
        },
    },
    computed: {
        userName(){
            return this.review.user.first_name + ' ' + this.review.user.last_name;
        },
        liked() {
            return this.review.like === 'LIKED';
        },
        disliked() {
            return this.review.like === 'DISLIKED';
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

    .icon {
        margin-right: 5px;
    }

    .level-item {
        color: #808080;
    }

    .liked {
        color: #23d160;
    }

    .disliked {
        color: red;
    }
</style>