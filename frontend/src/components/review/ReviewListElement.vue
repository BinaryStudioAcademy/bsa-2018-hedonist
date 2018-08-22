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

                    <template v-if="isImageAttached">
                        <div class="image is-3by1">
                            <img class="review-photo" :src="reviewImageUrl">
                        </div>
                    </template>

                    <LikeDislikeButtons
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

    computed: {
        userName() {
            return this.review.user.first_name + ' ' + this.review.user.last_name;
        },

        isImageAttached() {
            this.getReviewImage();
            return !_.isEmpty(this.reviewImageUrl);
        }
    },

    methods: {
        ...mapActions('review', ['getReviewPhoto']),
        getReviewImage: function() {
            this.getReviewPhoto(this.review.id)
                .then((result) => {
                    this.reviewImageUrl = result;
                })
                .catch(() => {
                    this.reviewImageUrl = '';
                });
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

    .icon {
        margin-right: 5px;
    }

</style>