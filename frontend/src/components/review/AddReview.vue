<template>
    <div>
        <div v-if="hasToken" class="add-review">
            <b-field class="media">

                <div class="media-left">
                    <img
                        v-if="getAuthenticatedUser.avatar_url"
                        :src="getAuthenticatedUser.avatar_url"
                        :title="getAuthenticatedUser.first_name+' '+getAuthenticatedUser.last_name"
                        :alt="getAuthenticatedUser.first_name+' '+getAuthenticatedUser.last_name"
                        height="32"
                        width="32"
                    >
                    <img
                        v-else
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
                                        <figure class="image review-preview-img">
                                            <img :src="getPreview(photo,index)">
                                        </figure>
                                        <span class="tag is-small is-white" @click="deletePhoto(index)">
                                            <a>{{ $t('place_page.review.photo.delete') }}</a>
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
                                    <a>{{ $t('place_page.review.photo.add') }}</a>
                                </span>
                            </b-upload>
                        </div>
                        <ul v-if="isTastes">
                            <li
                                v-for="(taste, index) in myTastes.byId"
                                class="taste"
                                :class="{added: isChecked(taste.id)}"
                                :key="taste.id"
                                :style="{ animationDelay: index * 0.02 + 's' }"
                            >
                                <div class="pill" @click="toggleTaste(taste.id)">
                                    {{ taste.name }}
                                    <i v-if="isChecked(taste.id)" class="fas fa-check" />
                                    <i v-else class="fas fa-plus" />
                                </div>
                            </li>
                        </ul>
                    </div>
                </b-field>

                <div class="media-right">
                    <button
                        class="button is-primary"
                        @click="onAddReview"
                    >
                        {{ $t('place_page.review.add') }}
                    </button>
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
import { mapGetters, mapActions, mapState } from 'vuex';

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
            selectedTasteIds: [],
            availableImageSize: 5000000,
        };
    },
    created() {
        this.fetchMyTastes();
    },
    computed: {
        isPhotos() {
            return !_.isEmpty(this.photos);
        },
        ...mapState('taste', ['myTastes']),
        ...mapGetters('auth', ['hasToken', 'getAuthenticatedUser']),
        userId: function () {
            return this.getAuthenticatedUser.id;
        },
        isTastes() {
            return !_.isEmpty(this.myTastes.byId);
        },
    },
    methods: {
        getPreview (photo,index) {
            if(this.checkFileSize(photo.size)){
                return URL.createObjectURL(photo).toString();
            } else {
                this.photos.splice(index, 1);
            }
        },
        checkFileSize(fileSize) {
            if (this.availableImageSize < fileSize) {
                this.onError({message: 'The photo has to be less than 5mb'});
                return false;
            }
            return true;
        },
        ...mapActions('review', ['addReview', 'addReviewPhoto']),
        ...mapActions('taste', ['fetchMyTastes']),
        ...mapActions('place', ['addTasteToPlace']),
        onAddReview () {
            this.newReview.user_id = this.userId;
            this.newReview.place_id = this.placeId;
            this.addReview({review: this.newReview, user: this.getAuthenticatedUser}).then((res) => {
                this.photos.forEach((item) => {
                    this.addReviewPhoto({
                        review_id: res.data.id,
                        description: '',
                        img: item
                    });
                });
                if (this.selectedTasteIds.length > 0) {
                    this.selectedTasteIds.forEach((item) => {
                        this.addTasteToPlace({
                            place_id: this.placeId,
                            taste_id: item
                        });
                    });
                    this.selectedTasteIds = [];
                }
                this.$emit('add', res.data.id);
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
        },
        isChecked(id) {
            return this.selectedTasteIds.includes(id);
        },
        toggleTaste(id) {
            if (this.selectedTasteIds.includes(id)) {
                this.selectedTasteIds.splice(this.selectedTasteIds.indexOf(id), 1);
            } else {
                this.selectedTasteIds.push(id);
            }
        },
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

            .review-preview-img{
                height: 80px;
                width: 80px;
            }

            img {
                height: 100%;
                border-radius: 10px;
            }
        }
    }

    .taste {
        animation-fill-mode: both;
        animation-duration: .2s;
        animation-iteration-count: 1;
        animation-timing-function: ease;

        display: inline-block;
        margin: 0 5px 7px 5px;

        .pill {
            border-radius: 100px;
            background: #2d5be3;
            color: #fff;
            cursor: pointer;
            font-size: 0.9rem;
            line-height: 100%;
            padding: 7px 10px 7px 12px;
            position: relative;

            i {
                margin-left: 5px;
            }
        }
        .pill:hover {
            top: -1px;
        }
        &.added {
            .pill {
                background: #f94877;
            }
        }
    }
</style>