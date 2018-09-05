<template>
    <div class="container is-fullhd is-fluid">
        <div class="container">
            <div class="columns user-info">

                <div class="column is-narrow">
                    <div class="user-info-img">
                        <figure class="image is-128x128">
                            <img
                                v-if="userProfile.avatar_url"
                                :src="userProfile.avatar_url"
                                :title="fullName"
                                :alt="fullName"
                            >
                        </figure>
                    </div>
                </div>

                <div class="column user-info-stats">

                    <div class="user-stats-title">
                        <h1 class="subtitle is-3">{{ fullName }}</h1>
                        <div class="user-social">
                            <a
                                v-if="userProfile.facebook_url"
                                v-show="userProfile.facebook_url" 
                                :href="userProfile.facebook_url" 
                                class="facebbok-link"
                                target="_blank"
                            >
                                <i class="fa-2x fab fa-facebook-square" />
                            </a>
                            <a
                                v-if="userProfile.twitter_url"
                                v-show="userProfile.twitter_url" 
                                :href="userProfile.twitter_url" 
                                class="twitter-link"
                                target="_blank"
                            >
                                <i class="fa-2x fab fa-twitter-square" />
                            </a>
                            <a
                                v-if="userProfile.instagram_url"
                                v-show="userProfile.instagram_url"
                                :href="userProfile.instagram_url"
                                class="instagram-link"
                                target="_blank"
                            >
                                <i class="fa-2x fab fa-instagram" />
                            </a>
                        </div>
                    </div>

                    <div class="user-stats-contact">
                        <span>Odessa</span>
                    </div>

                    <div class="user-stats-complaint">
                        <span>Пожаловаться на этого человека?</span>
                    </div>
                </div>

                <div class="column user-info-relation">

                    <ul class="level">
                        <li class="level-item has-text-centered">
                            <div>
                                <p class="relation-count">{{ AllReviewUserLength }}</p>
                                <p class="relation-title">Reviews</p>
                            </div>
                        </li>
                        <li class="level-item has-text-centered">
                            <div>
                                <p class="relation-count">105</p>
                                <p class="relation-title">Followers</p>

                            </div>
                        </li>
                        <li class="level-item has-text-centered">
                            <div>
                                <p class="relation-count">350</p>
                                <p class="relation-title">Following</p>
                            </div>
                        </li>
                        <li class="level-item has-text-centered">
                            <div>
                                <p class="relation-count">{{ UserListsLength }}</p>
                                <p class="relation-title">Lists</p>
                            </div>
                        </li>
                    </ul>

                    <div class="btn-follow">
                        <a class="button is-info">
                            <span class="icon is-small">
                                <i class="fas fa-plus-circle" />
                            </span>
                            <span>Follow {{ userProfile.first_name }}</span>
                        </a>
                    </div>

                </div>
            </div>

        </div>
    </div>
</template>

<script>
import {mapState, mapActions, mapGetters} from 'vuex';

export default {
    name: 'GeneralInfo',
    data() {
        return {

        };
    },
    created() {
        this.$store.dispatch('users/getUsersProfile', this.$route.params.id);
    },
    computed: {
        ...mapGetters('users',['getUserProfile']),
        ...mapGetters('place', ['getUserReviewsAll']),
        AllReviewUserLength: function () {
            return this.getUserReviewsAll(parseInt(this.$route.params.id)).length;
        },
        ...mapState('userList', {
            userLists: 'userLists',
        }),
        UserListsLength: function () {
            return this.userLists ? this.userLists.allIds.length : null;
        },
        fullName(){
            return this.userProfile.first_name + ' ' + this.userProfile.last_name
        },
        userProfile(){
            return this.getUserProfile(this.$route.params.id)
        }
    },
    methods: {
        ...mapActions({
            getUsersProfile: 'users/getUsersProfile',
        })
    }
};
</script>

<style lang="scss" scoped>

    .is-fullhd {
        margin: 10px 0;
        padding: 20px 0;
        background-color: #fff;
    }

    .user-info {

        &-img {
            @media screen and (max-width: 768px) {
                display: flex;
                justify-content: center;
            }
            img {
                border-radius: 32px;
            }

        }

        &-stats {

            .user-stats-title {
                h1 {
                    display: inline-block;
                    margin-right: 15px;
                    margin-bottom: 0;
                    @media screen and (max-width: 768px) {
                        text-align: center;
                        display: block;
                    }
                }
                .user-social {
                    display: inline-block;
                    @media screen and (max-width: 768px) {
                        display: block;
                        text-align: center;
                        margin: 10px 0;
                    }
                }
                a {
                    display: inline-block;
                    transition: 0.3s linear;
                    &:hover {
                        color: #5a5866;
                    }
                }
                .facebbok-link {
                    color: #4E71A8;
                    margin-right: 7px;
                }

                .twitter-link {
                    color: #1CB6EA;
                    margin-right: 7px;
                }

                instagram-link{
                    color: #c557d5;
                }
            }

            .user-stats-contact {
                span {
                    font-size: 0.75rem;
                }
            }

            .user-stats-complaint {
                span {
                    font-size: 0.75rem;
                    color: #aeb4b6;
                    cursor: pointer;

                    &:hover {
                        text-decoration: underline;
                    }
                }
            }

            .user-stats-contact,
            .user-stats-complaint {
                @media screen and (max-width: 768px) {
                    text-align: center;
                }
                span {
                    @media screen and (max-width: 768px) {
                        font-size: 16px;
                    }
                }
            }

        }

        &-relation {
            padding: 0;
            align-self: center;
            .btn-follow {
                display: flex;
                justify-content: center;
                a {
                    width: 250px;
                }
            }
            .level {
                margin-bottom: 20px;
                li {
                    border-right: 1px solid rgba(199, 205, 207, 0.3);
                    transition: 0.2s linear;

                    &:nth-last-child(1) {
                        border-right: none;
                    }

                    &:hover {
                        cursor: pointer;
                        background-color: rgba(199, 205, 207, 0.3);
                    }
                }

            }
            .relation-count {
                font-weight: bold;
                font-size: 20px;
            }
            .relation-title {
                font-size: 12px;
                color: #aeb4b6;
            }
        }
    }
</style>