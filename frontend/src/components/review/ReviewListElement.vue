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
                            <a class="level-item">
                                <span class="icon is-small" @click="onLikeReview"><i class="far fa-thumbs-up" /></span>
                                <span class="is-size-6">{{ review.likes }}</span>
                            </a>
                            <a class="level-item">
                                <span class="icon is-small" @click="onDislikeReview"><i class="far fa-thumbs-down"/></span>
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
        ...mapActions('review', ['likeReview', 'dislikeReview']),
        onLikeReview() {
            console.log(this.review);
            this.likeReview(this.review.id);
        },
        onDislikeReview() {
            this.dislikeReview(this.review.id);
        }
    },
    computed: {
        userName(){
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

    .icon {
        margin-right: 5px;
    }

</style>