<template>
    <div>
        <div v-if="hasToken" class="add-review">
            <b-field class="media">

                <div class="media-left">
                    <img
                        src="/assets/add_review_default_avatar.png"
                        height="32"
                        width="32"
                    >
                </div>

                <b-field class="media-content">
                    <div class="content-wrapper">
                        <b-input v-model="newReview.description" maxlength="500" type="textarea" />

                        <div v-if="isPhotos" class="review-preview-wrp">
                            <template v-for="(photo, index) in photos">
                                <div :key="index">
                                    <div class="photo">
                                        <figure class="image is-square is-48x48">
                                            <img :src="getPreview(photo)">
                                        </figure>
                                        <span class="tag is-small is-white" @click="deletePhoto(index)">
                                            <a>delete</a>
                                        </span>
                                    </div>
                                </div>
                            </template>
                        </div>

                        <div class="level">
                            <b-upload 
                                class="level-left"
                                v-model="photos"
                                accept="image/*"
                                multiple
                            >
                                <span class="tag is-light is-medium">
                                    <a>Add photo</a>
                                </span>
                            </b-upload>
                        </div>

                    </div>
                </b-field>

                <div class="media-right">
                    <button
                        class="button is-primary"
                        @click="onAddReview"
                    >Post</button>
                </div>
            </b-field>
        </div>
        <div v-else class="add-review media">
            <div class="media-left">
                <img
                    src="/assets/add_review_default_avatar.png"
                    height="32"
                    width="32"
                >
            </div>
            <span class="media-content">
                <a>Login</a>, to leave a review.
            </span>
            <div class="add-review-btn media-right">
                <button
                    class="button is-primary"
                    disabled
                >Post</button>
            </div>
        </div>
    </div>
</template>

<script>
import { mapGetters, mapActions } from 'vuex';

export default {
    name: 'AddReview',
    props: {
        placeId: {
            type: Number,
            required: true
        }
    },
    data: function () {
        return {
            newReview: {
                user_id: null,
                place_id: null,
                description: ''
            },
            photos: [],
        };
    },
    computed: {
        isPhotos() {
            return !_.isEmpty(this.photos);
        },

        ...mapGetters('auth', ['hasToken', 'getAuthenticatedUser']),
        userId: function () {
            return this.getAuthenticatedUser.id;
        }
    },
    methods: {
        getPreview (photo) {
            return URL.createObjectURL(photo).toString();
        },

        ...mapActions('review', ['addReview', 'addReviewPhoto']),
        onAddReview () {
            this.newReview.user_id = this.userId;
            this.newReview.place_id = this.placeId;

            this.addReview(this.newReview).then((res) => {
                this.photos.forEach((item, i, arr) => {
                    this.addReviewPhoto({
                        review_id: res.data.id,
                        description: 'test',
                        img: item
                    });
                });

                this.refreshInput();
                this.onSuccess({
                    message: 'Your review has been added'
                });
            })
                .catch((res) => {
                    this.onError(res.response.data);
                });
        },
        refreshInput () {
            this.newReview = {
                user_id: null,
                place_id: null,
                description: ''
            };
            this.photos = [];
        },
        onError (error) {
            this.$toast.open({
                message: error.message,
                type: 'is-danger'
            });
        },

        onSuccess (success) {
            this.$toast.open({
                message: success.message,
                type: 'is-success'
            });
        },
        deletePhoto(index) {
            this.photos.splice(index, 1);
        }
    }
};
</script>

<style lang="scss" scoped>
    .add-review {
        padding: 15px;
        align-items: center;
    }

    .review-preview-wrp {
        display: flex;
        flex-wrap: wrap;
        justify-content: flex-start;

        .photo {
            margin: 0 15px 10px 0;

            img {
                border: 1px solid #4e595d;
            }
        }
    }
</style>