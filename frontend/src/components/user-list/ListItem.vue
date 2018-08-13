<template>
    <transition name="slide-fade">
        <div class="item" v-if="isActive">
            <figure class="image is-16by9">
                <img :src="place.photo.url"/>
            </figure>
            <div class="content">
                <div class="columns">
                    <div class="column is-10">
                        <h3 class="title is-4 has-text-info">
                            {{place.name}}
                        </h3>
                        <div class="address">
                            {{place.address}}
                        </div>
                        <div class="category">
                            <a href="#" class="link">
                                {{place.category}}
                            </a>
                            •
                            <a class="link" href="#">
                                Reviews
                            </a>
                            : {{place.reviews.length}}
                        </div>
                    </div>
                    <div class="column">
                        <RatingComponent :rating="place.rating" class="rating"/>
                    </div>
                </div>
                <b-taglist>
                    <b-tag
                            type="is-info"
                            v-for="tag in place.tags"
                            :key="tag.id"
                    >
                        {{tag.name}}
                    </b-tag>
                </b-taglist>
                <button class="button is-info">
                    <i class="fas fa-save"></i>
                    <p class="icon-text">
                        save
                    </p>
                </button>
            </div>
        </div>
    </transition>
</template>

<script>
    import RatingComponent from './PlaceRating'

    export default {
        name: "ListItem",
        components: {RatingComponent},
        props: {
            place: {
                required: true,
                type: Object
            },
            timerOrder: {
                required: false,
                type: Number,
                default: 0,
            }
        },
        data() {
            return {
                isActive: false
            };
        },
        created() {
            setTimeout(() => {
                this.isActive = true
            }, (1 + this.timerOrder) * 200);
        }
    }
</script>

<style lang="scss" scoped>
    .item {
        background: #FFF;
    }

    .title {
        margin-bottom: 0.5rem;
        align-self: center;
    }

    .columns {
        margin-bottom: 0;
    }

    .content {
        padding: 1rem;
    }

    .address {
        color: grey;
        margin-bottom: 0.5rem;
    }

    .category {
        color: grey;
        margin-bottom: 1rem;
    }

    .link {
        color: grey;
        transition: color 0.3s;
        &:hover {
            text-decoration: underline;
            color: black;
        }
    }

    .rating {
        margin: 0 auto 0 auto;
    }

    .address, .title, .category {
        text-align: center;
    }

    .button > .icon-text {
        margin-left: 10px;
    }

    @media screen and (min-width: 769px) {
        .rating {
            margin: 0 0 0 auto;
        }

        .address, .title, .category {
            text-align: left;
        }
    }

    //TRANSITION

    .slide-fade-enter-active {
        transition: all 0.5s ease;
    }

    .slide-fade-enter, .slide-fade-leave-to {
        transform: translateX(500px);
        opacity: 0;
    }
</style>