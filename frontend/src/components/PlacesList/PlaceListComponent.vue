<template>
    <div class="container place-item">
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
                    {{place.name}}
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
        <div class="media" v-if="place.review">
            <div class="media-left">
                <figure class="image is-32x32">
                    <img :src="place.review.user.avatar"/>
                </figure>
            </div>
            <div class="media-content">
                <div>
                    <a class="has-text-weight-semibold has-text-primary" href="#">
                        {{place.review.user.name}}
                    </a>
                    •
                    <small>{{place.review.published_at}}</small>
                </div>
                <p>
                    {{place.review.text}}
                </p>
                <nav class="level">
                    <div class="level-left">
                        <a class="level-item">
                            <b-taglist attached>
                                <b-tag type="is-light">
                                    {{place.review.likes}}
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
                                    {{place.review.dislikes}}
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
        <hr>
    </div>
</template>

<style scoped>
    .place-item {
        color: grey;
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
    }

    .place-category > a {
        color: grey;
        -webkit-transition: color 0.3s;
        -moz-transition: color 0.3s;
        -ms-transition: color 0.3s;
        -o-transition: color 0.3s;
        transition: color 0.3s;
    }

    .place-category > a:hover {
        color: black;
        text-decoration: underline;
    }

    .rating-wrapper {
        margin-top: 1.5rem;
    }

    hr {
        color: grey;
        border-width: 3px;
    }

    @media screen and (min-width: 769px) {
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
        props:
            {
                place:
                    {
                        required: true,
                        type: Object,
                    }
            },
        methods:
            {
                like(){
                    this.$toast.open({
                        message:'You liked this review!',
                        type:'is-info',
                        position:'is-bottom'
                    })
                },
                dislike(){
                    this.$toast.open({
                        message: `You disliked this review`,
                        position: 'is-bottom',
                        type: 'is-info'
                    });
                },
                subscribe(){
                    this.$toast.open({
                        message: `You now will recive updates on this place`,
                        position: 'is-bottom',
                        type: 'is-info'
                    });
                }
            }
    }
</script>