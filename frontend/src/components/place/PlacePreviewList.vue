<template>
    <transition name="slide-fade">
        <div
                class="container place-item"
                v-if="active"
        >
            <div class="level is-mobile">
                <div class="level-left">
                    <figure class="image is-128x128 level-item">
                        <!-- TODO set place photo url -->
                        <img src="https://igx.4sqi.net/img/general/200x200/887035_CLhGX1rsu2-V75shOAkPWuxXLY2k4iO17hEdOlOfSWc.jpg">
                    </figure>
                </div>
                <div class="level-right rating-wrapper ">
                    <div class="level-item">
                        <div class="rating">
                            {{ place.rating }}
                        </div>
                    </div>
                </div>
            </div>
            <div class="content-wrapper">
                <h3 class="title has-text-primary">
                    <router-link :to="`/places/${place.id}`">
                        {{ place.localization[0].name }}
                    </router-link>
                </h3>
                <p class="place-category">
                    <a href="#">{{ place.category.name }}</a>
                </p>
                <p class="address">
                    {{ place.address }}
                </p>
                <b-taglist>
                    <b-tag
                            type="is-info"
                            v-for="tag in place.category.tags"
                            :key="tag.id"
                    >
                        {{ tag.name }}
                    </b-tag>
                </b-taglist>
            </div>
            <div
                    class="media"
                    v-if="place.reviews !== undefined && place.reviews[0] !== undefined"
            >
                <div class="media-left">
                    <figure class="image is-32x32">
                        <img :src="place.reviews[0].user.avatar">
                    </figure>
                </div>
                <div class="media-content">
                    <div>
                        <a
                                class="has-text-weight-semibold has-text-primary"
                                href="#"
                        >
                            {{ place.reviews[0].user.name }}
                        </a>
                        •
                        <small>{{ place.reviews[0].published_at }}</small>
                    </div>
                    <p>
                        {{ place.reviews[0].text }}
                    </p>
                    <nav class="level is-mobile">
                        <div class="level-left">
                            <a class="level-item likeable">
                                <i class="fas fa-thumbs-down"></i>
                                <span>
                                    {{0}}
                                </span>
                            </a>
                            <a class="level-item likable">
                                <i class="fas fa-thumbs-down likable"></i>
                                <span>
                                    {{0}}
                                </span>
                            </a>
                        </div>
                    </nav>
                </div>
            </div>
            <hr class="divider">
        </div>
    </transition>
</template>

<style lang="scss" scoped>
    .place-item {
        color: grey;
        max-width: 100%;
        background: #FFF;
    }

    .columns {
        width: 100%;
        margin: 0;
    }

    .title {
        margin-bottom: 0.5rem;
    }

    .image {
        margin: 0 auto;
        padding-top: 0.75rem;
    }

    .image > img {
        border-radius: 5px;
    }

    .place-category {
        margin-bottom: 0.25rem;
        a {
            color: grey;
            -webkit-transition: color 0.3s;
            -moz-transition: color 0.3s;
            -ms-transition: color 0.3s;
            -o-transition: color 0.3s;
            transition: color 0.3s;

            &:hover {
                color: black;
                text-decoration: underline;
            }
        }
    }

    .address {
        margin-bottom: 0.5rem;
    }

    .rating {
        width: 48px;
        height: 48px;
        background: #00E676;
        border-radius: 7px;
        margin: auto;
        line-height: 48px;
        font-size: 1.5rem;
        color: #FFF;
        text-align: center;
    }

    .rating-wrapper {
        margin-left: auto;
        margin-right: 5px;
        align-self: flex-start;
    }

    .slide-fade-enter-active {
        transition: all 0.5s ease;
    }

    .slide-fade-enter, .slide-fade-leave-to {
        transform: translateX(300px);
        opacity: 0;
    }

    .divider {
        border: 1px solid #DDD;
        margin-bottom: 0.5rem;
    }

    .likeable {
        color: rgba(221, 221, 221, 0.6);
        cursor: pointer;

        &:hover {
            color: #4e595d;
        }
    }

    @media screen and (min-width: 769px) {
        .place-item {
            max-width: 100%;
            padding: 10px;
        }

        .title, .place-category, .address {
            text-align: left;
        }

        .content-wrapper {
            margin-right: 0.5rem;
        }
    }

</style>

<script>
    export default {
        name: 'PlaceListComponent',
        data() {
            return {
                active: false
            };
        },
        props: {
            place: {
                required: true,
                type: Object,
            },
            timer: {
                required: true,
                type: Number,
            }
        },
        methods: {
            like() {
                this.$toast.open({
                    message: 'You liked this review!',
                    type: 'is-info',
                    position: 'is-bottom'
                });
            },
            dislike() {
                this.$toast.open({
                    message: 'You disliked this review',
                    position: 'is-bottom',
                    type: 'is-info'
                });
            }
        },
        created() {
            setTimeout(() => {
                this.active = true;
            }, this.timer);
        }
    };
</script>