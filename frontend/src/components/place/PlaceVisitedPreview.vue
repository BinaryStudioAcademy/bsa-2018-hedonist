<template>
    <transition name="slide-fade">
        <article v-if="active">
            <div class="entry-media">
                <img 
                    class="image" 
                    :src="visitedPlace.place_photo.url"
                >
            </div>
            <div class="item-description">
                <div class="rating-wrapper">
                    <div class="rating">
                        {{ visitedPlace.ratings.rating }}
                    </div>
                </div>
                <h2 class="title">{{ index }}.{{ visitedPlace.places_tr.place_name }}</h2>
                <p>{{ cityAddress }}</p>
                <p>{{ visitedPlace.categories.name }} - Tips and feedback: {{ reviewCount }}</p>

                <button class="saved"><i class="fa fa-bookmark" />Saved</button>
            </div>
        </article>
    </transition>
</template>

<style lang="scss" scoped>

    article {
        margin: 1.5rem auto;
        text-align: left;
        width: 600px;
        background-color: #FFF;
    }

    .entry-media {
        height: 300px;
        width: 600px;
    }

    .image {
        margin: 0 auto;
        max-width: 400px;
        max-height: 300px;
    }

    .item-description {
        margin-left: 0.5rem;
        margin-right: 0.5rem;

        .rating-wrapper {
            float: right;
        }

        p {
            padding-left: 0.5rem;
        }

        .saved {
            padding-top: 0.3rem;
            padding-bottom: 0.3rem;
            margin-top: 1rem;
            margin-bottom: 1rem;

            i {
                padding-right: 0.6rem;
                color: #00E676;
            }
        }
    }

    .title {
        margin-top: 1.5rem;
        padding-left: 0.5rem;
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

    .slide-fade-enter-active {
        transition: all 0.5s ease;
    }

    .slide-fade-enter, .slide-fade-leave-to {
        transform: translateX(300px);
        opacity: 0;
    }
</style>

<script>
export default {
    name: 'PlaceVisitedPreview',
    data() {
        return {
            active: false
        };
    },
    props: {
        visitedPlace: {
            required: true,
            type: Object,
        },
        index: {
            required: true,
            type: Number
        },
        timer: {
            required: true,
            type: Number
        }
    },
    computed: {
        cityAddress: function() {
            return this.visitedPlace.address + ', ' + this.visitedPlace.cities.name;
        },
        reviewCount: function() {
            return this.visitedPlace.reviews.length || 0;
        }
    },
    created() {
        setTimeout(() => {
            this.active = true;
        }, this.timer);
    }
};
</script>