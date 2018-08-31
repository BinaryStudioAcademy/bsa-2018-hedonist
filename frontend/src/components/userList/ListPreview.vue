<template>
    <transition name="slide-fade">
        <li>
            <div class="container place-item" v-if="active">
                <div class="media">
                    <figure class="media-left image">
                        <img :src="userList.img_url">
                    </figure>
                    <div class="media-content">
                        <h3 class="title has-text-primary">
                            <router-link :to="`/list/${userList.id}`">
                                {{ userList.name }}
                            </router-link>
                        </h3>
                        <p class="place-category">
                            <a href="#">Places saved in the list: {{ userList.places | countPlaces }}</a>
                        </p>
                        <p class="address">
                            Cities in the list:
                            <a
                                v-for="(city,index,key) in uniqueCities"
                                :key="index"
                                href="#"
                                @click="setCityFilter(city.id)"
                            >{{ city.name }}
                                <span v-show="notLast(key)">, </span>
                            </a>
                        </p>
                    </div>
                    <div class="place-item__actions">
                        <router-link
                            class="button is-info"
                            role="button"
                            :to="`/my-lists/${userList.id}/edit`"
                        >
                            Update
                        </router-link>
                        <button class="button is-danger" @click="onDelete">Delete</button>
                    </div>
                </div>
            </div>
        </li>
    </transition>
</template>

<script>
import { mapGetters, mapActions } from 'vuex';
export default {
    name: 'ListPreview',
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
        ...mapGetters('userList', {
            getUniqueCities : 'getUniqueCities'
        }),
        uniqueCities: function () {
            return this.getUniqueCities(this.userList);
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
        ...mapActions({ delete: 'userList/deleteUserList' }),
        notLast(key) {
            return Object.keys(this.uniqueCities).length - key > 1;
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
        },
        onDelete() {
            this.$emit('loading', true);
            this.delete(this.userList.id)
                .then(() => {
                    this.$toast.open({
                        message: 'The list was removed',
                        position: 'is-top',
                        type: 'is-info'
                    });
                });
        }
    },
    created() {
        setTimeout(() => {
            this.active = true;
        }, this.timer);
    },
    beforeDestroy() {
        this.$emit('loading', false);
    }
};
</script>

<style lang="scss" scoped>
    .place-item {
        background: #FFF;
        color: grey;
        max-width: 100%;
        margin-bottom: 1rem;
        margin-left: 0;
        padding: 10px;
        border-bottom: 1px grey solid;

        &__actions {
            display: flex;
            flex-direction: column;
            margin-top: auto;

            .button {
                margin-top: 10px;
            }
        }
    }
    .columns {
        width: 100%;
        margin: 0;
    }
    .title {
        margin-bottom: 0.5rem;
    }
    .image {
        width: 180px;
        height: 128px;
        flex-shrink: 0;

        img {
            width: 100%;
            height: 100%;
            object-fit: cover;
            object-position: 50% 50%;
        }
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

    @media screen and (max-width: 769px) {
        .place-item {
            .media {
                flex-direction: column;
                align-items: center;
            }

            &__actions {
                flex-direction: row;

                .button {
                    margin-right: 10px;
                }
            }
        }
    }
</style>