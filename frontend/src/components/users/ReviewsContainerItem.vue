<template>


    <li class="column is-4">
        <div class="user-reviews-item">

            <div class="card-image">
                <figure class="image is-3by1">
                    <img
                        :src="place.photos[0].img_url"
                    >
                </figure>
                <div class="user-review-save">
                    <a class="button ">
                        <span class="icon">
                            <i class="far fa-bookmark" />
                        </span>
                        <span>Save</span>
                    </a>
                </div>
            </div>
            <div class="user-review-content">
                "{{ place.review.description }}"
            </div>
            <div class="user-review-tip">
                <router-link :to="`/user/${place.review.user.id}`" class="user-tip-image">

                    <img
                        class="image is-32x32"
                        :src="place.review.user.avatar_url"

                        alt=""
                    >
                </router-link>
                <span class="user-tip-name">
                    <a href="/user/4">
                        Alex Fiannaca
                    </a>
                </span>
                <span class="user-tip-date">
                    <router-link :to="`/places/${place.review.id}`">
                        {{ date }}
                    </router-link>
                </span>
            </div>
            <div class="user-review-place">
                <div class="user-review-name">
                    <router-link :to="`/places/${place.id}`" class="review-place-link">
                        {{ place.localization[0].name }}
                    </router-link>
                    <span class="review-place-name">
                        {{ place.category.name }}
                    </span>
                    <span class="review-place-city">
                        {{ place.city.name }}
                    </span>
                </div>
                <div class="media">
                    <div class="media-right rating-wrapper">
                        <PlaceRating
                            :value="Number(place.rating)"
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
        place: {
            required: true,
            type: Object,
        },
    },
    computed: {
        date() {
            const date = new Date(this.place.review['created_at']);
            const options = {
                year: 'numeric',
                month: 'long',
                day: 'numeric',
            };
            return date.toLocaleString('en-US', options);
        }
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

            .user-tip-image {
                margin-right: 10px;
                img {
                    vertical-align: middle;
                }
            }

            .user-tip-name,
            .user-tip-date {
                margin-right: 10px;
                a {
                    color: #aeb4b6;
                    font-size: 12px;
                    &:hover {
                        text-decoration: underline;
                    }
                }
            }

            .user-tip-date {
                margin-right: 0;
            }

        }

        .user-review-place {
            padding: 10px 20px;
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