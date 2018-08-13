<template>
    <transition name="slide-fade">
        <div class="container place-item" v-if="active">
            <div class="columns">
                <figure class="image is-128x128">
                    <img :src="place.photo.url"/>
                </figure>
                <div class="rating-wrapper">
                    <div class="rating">
                        {{place.rating}}
                    </div>
                </div>
                <div class="column content-wrapper">
                    <h3 class="title has-text-primary">
                        <router-link :to="`/places/${place.id}`">
                            {{place.name}}
                        </router-link>
                        <a class="button is-outlined is-info" @click="subscribe">
                            <i class="fas fa-bell"></i>
                        </a>
                    </h3>
                    <p class="place-category">
                        <a href="#">{{place.category}}</a>
                    </p>
                    <p class="address">
                        {{place.address}}
                    </p>
                    <b-taglist>
                        <b-tag
                                type="is-info"
                                v-for="tag in place.tags"
                                :key="tag.id"
                        >
                            {{tag.name}}
                        </b-tag>
                    </b-taglist>
                </div>
            </div>
            <div class="media" v-if="place.reviews[0]">
                <div class="media-left">
                    <figure class="image is-32x32">
                        <img :src="place.reviews[0].user.avatar"/>
                    </figure>
                </div>
                <div class="media-content">
                    <div>
                        <a class="has-text-weight-semibold has-text-primary" href="#">
                            {{place.reviews[0].user.name}}
                        </a>
                        •
                        <small>{{place.reviews[0].published_at}}</small>
                    </div>
                    <p>
                        {{place.reviews[0].text}}
                    </p>
                    <nav class="level">
                        <div class="level-left">
                            <a class="level-item">
                                <b-taglist attached>
                                    <b-tag type="is-light">
                                        {{place.reviews[0].likes}}
                                    </b-tag>
                                    <b-tag type="is-success" @click.native="like">
                                    <span class="icon">
                                        <i class="far fa-arrow-alt-circle-up"></i>
                                    </span>
                                    </b-tag>
                                </b-taglist>
                            </a>
                            <a class="level-item">
                                <b-taglist attached>
                                    <b-tag type="is-light">
                                        {{place.reviews[0].dislikes}}
                                    </b-tag>
                                    <b-tag type="is-danger" @click.native="dislike">
                                    <span class="icon">
                                        <i class="far fa-arrow-alt-circle-down"></i>
                                    </span>
                                    </b-tag>
                                </b-taglist>
                            </a>
                        </div>
                    </nav>
                </div>
            </div>
        </div>
    </transition>
</template>

<style lang="scss" scoped>
    .place-item {
        color: grey;
        max-width: 100%;
        margin-bottom:1rem;
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
        a{
            color: grey;
            -webkit-transition: color 0.3s;
            -moz-transition: color 0.3s;
            -ms-transition: color 0.3s;
            -o-transition: color 0.3s;
            transition: color 0.3s;

            &:hover{
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
        margin-top: 1.5rem;
    }

    hr {
        color: grey;
        border-width: 3px;
    }

    .slide-fade-enter-active {
        transition: all 0.5s ease;
    }

    .slide-fade-enter, .slide-fade-leave-to {
        transform: translateX(300px);
        opacity: 0;
    }

    @media screen and (min-width: 769px) {
        .place-item {
            max-width: 100%;
            padding: 10px;
            background: #FFF;
        }

        .title, .place-category, .address {
            text-align: left;
        }

        .image {
            order: 1;
        }

        .content-wrapper {
            order: 2;
            margin-right: 0.5rem;
        }

        .rating-wrapper {
            order: 3;
            margin-top: 0.5rem;
        }
    }

</style>

<script>
    export default {
        name: "PlaceListComponent",
        data() {
            return {
                active: false
            }
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
                })
            },
            dislike() {
                this.$toast.open({
                    message: `You disliked this review`,
                    position: 'is-bottom',
                    type: 'is-info'
                });
            },
            subscribe() {
                this.$toast.open({
                    message: `You now will recive updates on this place`,
                    position: 'is-bottom',
                    type: 'is-info'
                });
            }
        },
        created() {
            setTimeout(() => {
                this.active = true
            }, this.timer)
        }
    }
</script>