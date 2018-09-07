<template>


    <li class="column is-4">
        <div class="user-reviews-item">

            <div
                class="card-image"
                :style="{ 'background-image': 'url(' + review.place.photo.img_url + ')' }"
            />
            <div class="user-review-content">
                "{{ review.description }}"
            </div>
            <div class="user-review-tip">
                <span
                    v-if="review.user.avatar_url"
                    class="user-tip-avatar user-tip-image"
                    :style="{ 'background-image': 'url(' + review.user.avatar_url + ')' }"
                />
                <span class="user-tip-name">
                    {{ userName }}
                </span>
                <span class="user-tip-date">
                    {{ date }}
                </span>
            </div>
            <div class="user-review-place">
                <div class="user-review-name">
                    <router-link :to="`/places/${review.place_id}`" class="review-place-link">
                        {{ review.place.localization[0].name }}
                    </router-link>
                    <span class="review-place-name">
                        {{ review.place.category.name }}
                    </span>
                    <span class="review-place-city">
                        {{ review.place.city.name }}
                    </span>
                </div>
                <div class="media">
                    <div class="media-right rating-wrapper">
                        <PlaceRating
                            :value="Number(review.place.rating)"
                        />
                    </div>
                </div>
            </div>
        </div>
    </li>

</template>

<script>
import {mapState, mapActions, mapGetters} from 'vuex';
import PlaceRating from '@/components/place/PlaceRating';

export default {
    name: 'ReviewsContainerItem',
    data() {
        return {};
    },
    props: {
        review: {
            required: true,
            type: Object,
        },
    },
    computed: {
        date() {
            const date = new Date(this.review['created_at']);
            const options = {
                year: 'numeric',
                month: 'long',
                day: 'numeric',
            };
            return date.toLocaleString('en-US', options);
        },
        userName() {
            const user = this.review.user;
            return user.first_name + ' ' + user.last_name;
        },
    },
    components: {
        PlaceRating,
    },

};
</script>
<style lang="scss">
    .user-reviews-container {
        margin-top: 60px;
    }
    .user-reviews-header {
        display: flex;
        justify-content: space-between;
        @media screen and (max-width: 768px) {
            text-align: center;
            flex-direction: column;
            margin-bottom: 20px;
        }
    }
</style>
<style lang="scss" scoped>

    .user-reviews-container {
        margin-top: 60px;

        .header-btn {
            a {
                width: 300px;
            }
            span {
                font-size: 18px;
                padding: 0 30px;
                font-weight: normal;
            }
        }
    }

    .user-reviews {
        margin: 20px 0;
    }

    .user-reviews-item {
        background-color: #fff;
        box-shadow: 0px 4px 4px 0px rgba(0, 0, 0, 0.28);
        align-items: center;

        .card-image {
            position: relative;
            padding: 16.7% 0;
            background-position: center;
            background-size: cover;

            .user-review-save {
                display: inline-block;
                position: absolute;
                top: 10px;
                right: 15px;

                span {
                    color: #56565C;
                }

                i {
                    color: #e3e3e8;
                    transition: 0.2s linear;
                }

                &:hover {
                    i {
                        color: #56565C;
                    }
                }
            }
        }

        .user-review-content {
            padding: 20px;
            height: 153px;
            font-size: 17px;
            line-height: 26px;
            font-weight: 300;
            word-wrap: break-word;
            overflow: hidden;
        }

        .user-review-tip {
            padding: 0 20px;
            display: flex;
            align-items: center;
            border-bottom: 1px solid #efeff4;
            height: 40px;

            .user-tip-avatar {
                width: 32px;
                height: 32px;
                margin-right: 10px;
                background-position: center;
                background-size: cover;
            }

            .user-tip-name,
            .user-tip-date {
                margin-right: 10px;
                color: #aeb4b6;
                font-size: 12px;
            }

            .user-tip-date {
                margin-right: 0;
            }
        }

        .user-review-place {
            padding: 0 20px;
            margin-top: 10px;
            display: flex;
            justify-content: space-between;
            align-items: center;

            .user-review-name {

                .review-place-link {
                    display: block;
                    color: #5656ce;

                    &:hover {
                        text-decoration: underline;
                    }
                }

                .review-place-name,
                .review-place-city {
                    font-size: 12px;
                    color: #aeb4b6;
                }

                .review-place-city::before {
                    content: '';
                    display: inline-block;
                    width: 2px;
                    height: 2px;
                    background-color: #aeb4b6;
                    vertical-align: middle;
                    margin-bottom: 2px;
                }

            }

            .rating-wrapper {
                .rating {
                    padding: 0 5px;
                    line-height: 28px;
                    font-size: 14px;
                    font-weight: bold;
                }

            }
        }
    }
</style>