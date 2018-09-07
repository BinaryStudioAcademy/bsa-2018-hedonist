<template>
    <div class="container is-fullhd is-fluid">
        <template v-if="userProfile">
            <div class="container">
                <div class="columns user-info">
                    <div class="column is-narrow">
                        <div class="user-info-img">
                            <figure class="image is-128x128">
                                <img
                                    :src="avatar"
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
                    </div>

                    <div class="column user-info-relation">

                        <ul class="level">
                            <li class="level-item has-text-centered">
                                <div
                                    :class="{active_tab: selectionActive(pageConstants.reviewTab)}"
                                    @click="changeTab(pageConstants.reviewTab)"
                                >
                                    <p class="relation-count">{{ AllReviewUserLength }}</p>
                                    <p class="relation-title">{{ $t('other_user_page.reviews') }}</p>
                                </div>
                            </li>
                            <li class="level-item has-text-centered">
                                <div
                                    :class="{active_tab: selectionActive(pageConstants.followersTab)}"
                                    @click="changeTab(pageConstants.followersTab)"
                                >
                                    <p class="relation-count">{{ userProfile.followers.length }}</p>
                                    <p class="relation-title">{{ $t('other_user_page.followers') }}</p>
                                </div>
                            </li>
                            <li class="level-item has-text-centered">
                                <div
                                    :class="{active_tab: selectionActive(pageConstants.followedTab)}"
                                    @click="changeTab(pageConstants.followedTab)"
                                >
                                    <p class="relation-count">{{ userProfile.followedUsers.length }}</p>
                                    <p class="relation-title">{{ $t('other_user_page.following') }}</p>
                                </div>
                            </li>
                            <li class="level-item has-text-centered">
                                <div
                                    :class="{active_tab: selectionActive(pageConstants.listTab)}"
                                    @click="changeTab(pageConstants.listTab)"
                                >
                                    <p class="relation-count">{{ UserListsLength }}</p>
                                    <p class="relation-title">{{ $t('other_user_page.lists') }}</p>
                                </div>
                            </li>
                        </ul>

                        <FollowButton
                            v-if="shouldShowFollowBtn"
                            @followed="followEventHandler"
                            :followed="isFollowedByCurrentUser"
                            :name="userProfile.first_name"
                        />

                    </div>
                </div>

            </div>
        </template>
    </div>
</template>

<script>
import {otherUserPage} from '@/services/common/pageConstants';
import {mapState, mapActions, mapGetters} from 'vuex';
import FollowButton from './FollowButton';
import defaultImage from '@/assets/user-placeholder.png';

export default {
    name: 'GeneralInfo',
    data() {
        return {
            pageConstants: otherUserPage
        };
    },
    props: {
        currentTab: {
            required: true,
            type: String
        }
    },
    components: {FollowButton},
    computed: {
        ...mapGetters('users', ['getUserProfile', 'getUserReviews']),
        ...mapGetters('auth', ['getAuthenticatedUser']),
        ...mapState('userList', {
            userLists: 'userLists',
        }),
        AllReviewUserLength: function () {
            return this.getUserReviews.length;
        },
        UserListsLength: function () {
            return this.userLists ? this.userLists.allIds.length : null;
        },
        fullName() {
            return this.userProfile.first_name + ' ' + this.userProfile.last_name;
        },
        userProfile() {
            return this.getUserProfile(parseInt(this.$route.params.id));
        },
        isFollowedByCurrentUser() {
            return this.userProfile.followers.includes(this.getAuthenticatedUser.id);
        },
        avatar() {
            return this.userProfile.avatar_url || defaultImage;
        },
        shouldShowFollowBtn(){
            return !(this.getAuthenticatedUser.id === parseInt(this.$route.params.id));
        }
    },
    methods: {
        ...mapActions('users', ['followUser', 'unfollowUser']),
        followEventHandler(payload) {
            const newPayload = {
                ...payload,
                followedId: this.userProfile.id,
                follower: this.getAuthenticatedUser
            };
            if (!payload.currentStatus) {
                this.followUser(newPayload);
            } else {
                this.unfollowUser(newPayload);
            }
        },
        selectionActive(itemToCheck) {
            return this.currentTab === itemToCheck;
        },
        changeTab(tab) {
            this.$emit('tabChanged', tab);
        },
    },
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

                .instagram-link {
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
                    div {
                        width: 100%;
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

            .relation-count, .relation-title {
                transition: color 0.3s ease;
            }

            .active_tab {
                .relation-count {
                    color: #7957d5;
                }
                .relation-title {
                    color: #8563f4;
                }
            }
        }
    }
</style>