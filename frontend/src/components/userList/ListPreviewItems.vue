<template>
    <transition name="slide-fade">
        <div class="container place-item" v-if="active">
            <div class="media">
                <figure class="media-left image is-128x128">
                    <img :src="userList.img_url">
                </figure>
                <div class="media-content">
                    <h3 class="title has-text-primary">
                        <router-link :to="`/my-places/${userList.id}`">
                            {{ userList.name }}
                        </router-link>
                    </h3>
                    <p class="place-category">
                        <a href="#">Places saved in the list: {{ userList.places | countPlaces }}</a>
                    </p>
                    <p class="address">
                        Cities in the list:

                        <a
                            v-for="(city,index) in getUniqueCities"
                            :key="index"
                            href="#"
                            @click="setCityFilter(city.id)"
                        >{{ city.name }}<span v-show="notLast(index)">, </span> </a>
                    </p>
                </div>
            </div>
        </div>
    </transition>
</template>

<script>
export default {
    name: 'ListPreviewItems',
    data() {
        return {
            active: false
        };
    },
    filters: {
        countPlaces: function (places) {
            return places.length;
        },
    },
    computed: {
        getUniqueCities: function () {
            const places = this.userList.places;
            const cities = places.map(place => place.city);
            return cities.filter((a, i) =>
                i === cities.length - 1 ||
                a.id !== cities[i + 1].id
            );
        },
    },
    props: {
        userList: {
            required: true,
            type: Object,
        },
        timer: {
            required: true,
            type: Number,
        }
    },
    methods: {
        notLast: function (index) {
            return this.getUniqueCities.length - index > 1;
        },
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
        },
        setCityFilter(cityId){
            this.$parent.setCityFilter(cityId);
        }
    },
    created() {
        setTimeout(() => {
            this.active = true;
        }, this.timer);
    }
};
</script>

<style lang="scss" scoped>
    .place-item {
        background: #FFF;
        color: grey;
        max-width: 100%;
        margin-bottom: 1rem;
        padding: 10px;
    }
    .columns {
        width: 100%;
        margin: 0;
    }
    .title {
        margin-bottom: 0.5rem;
    }
    .image > img {
        border-radius: 5px;
    }
    .place-category {
        margin-bottom: 0.25rem;
        a {
            color: grey;
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
</style>