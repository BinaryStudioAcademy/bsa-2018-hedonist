<template>
    <div>
        <div v-if="hasToken" class="add-review">
            <b-field class="media">

                <div class="media-left">
                    <img
                        src="https://ss0.4sqi.net/img/venuepage/v2/add_tip_blank_avatar@2x-4321684c656168f26ae9208901a9d83e.png"
                        height="32"
                        width="32"
                    >
                </div>

                <b-field class="media-content">
                    <div class="content-wrapper">
                        <b-input v-model="newReview.description" maxlength="500" type="textarea" />

                        <b-taglist>
                            <b-tag 
                                v-for="(file, index) in photos"
                                :key="index"
                                type="is-primary"
                            >
                                {{ file.name }}
                                <button 
                                    class="delete is-small"
                                    type="button"
                                    @click="deletePhoto(index)"
                                />
                            </b-tag>

                            <b-upload 
                                v-model="photos"
                                accept="image/*"
                                multiple
                            >
                                <span class="tag is-light">
                                    <a>Add photo</a>
                                </span>
                            </b-upload>
                        </b-taglist>
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
                    src="https://ss0.4sqi.net/img/venuepage/v2/add_tip_blank_avatar@2x-4321684c656168f26ae9208901a9d83e.png"
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
import { mapGetters } from 'vuex';
import { mapActions } from 'vuex';

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
            photos: []
        };
    },
    computed: {
        ...mapGetters('auth', ['hasToken', 'getAuthenticatedUser']),
        userId: function () {
            return this.getAuthenticatedUser.id;
        }
    },
    methods: {
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

<style scoped>
    .add-review {
        padding: 15px;
        align-items: center;
    }
</style>