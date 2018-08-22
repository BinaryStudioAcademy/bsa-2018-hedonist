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

                    <div class="image">
                        <img :src="reviewImage" />
                    </div>

                    <LikeDislikeButtons
                        :likes="review.likes"
                        :dislikes="review.dislikes"
                        :like="review.like"
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
        }
    },

    computed: {
        userName() {
            return this.review.user.first_name + ' ' + this.review.user.last_name;
        },

        reviewImage() {
            this.getReviewImage();
            console.log('Image src: ' + this.reviewImageUrl);
            return this.reviewImageUrl;
        }


    },

    methods: {
        ...mapActions('review', ['getReviewPhoto']),
        getReviewImage: function() {
            this.getReviewPhoto(this.review.id)
                .then((result) => {
                    // this.reviewImageUrl = '/storage/app/public/upload/review/1534852163_680800804.png';
                    this.reviewImageUrl = result;
                    console.log("Image url = " + result);
                    // this.reviewImageUrl = "https://igx.4sqi.net/img/general/558x200/495199272_ccmT2ssi29nXeHqQNS2lR7aZzinX8DoU0pvVsEQjWII.jpg";
                })
                .catch(() => {
                    this.reviewImageUrl = '';
                })
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

    .icon {
        margin-right: 5px;
    }

</style>