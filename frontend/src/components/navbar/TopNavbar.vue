<template>
    <div class="is-paddingless">
        <nav class="navbar is-info is-fixed-top">
            <div class="navbar-wrapper container is-flex">
                <div class="navbar-brand navbar-brand-name">
                    <router-link
                        class="navbar-item"
                        to="/"
                    >HED<img class="logo-top" src="/assets/logo_top.png">NIST
                    </router-link>

                    <a
                        role="button"
                        class="navbar-burger"
                        aria-label="menu"
                        aria-expanded="false"
                        @click="toggleMenu"
                        :class="{'is-active': navIsActive}"
                    >

                        <span aria-hidden="true" />
                        <span aria-hidden="true" />
                        <span aria-hidden="true" />
                    </a>
                </div>

                <div class="navbar-menu" :class="{'is-active': navIsActive}">
                    <NavbarSearchPanel v-if="isUserLoggedIn" />
                    <div
                        v-if="!isUserLoggedIn"
                        class="navbar-end"
                    >
                        <router-link
                            class="navbar-item"
                            to="/login"
                        >{{ $t('navbar.login') }}</router-link>
                        <router-link
                            class="navbar-item"
                            to="/signup"
                        >{{ $t('navbar.signup') }}</router-link>
                    </div>

                    <div
                        v-if="isUserLoggedIn"
                        class="navbar-end"
                    >
                        <div class="notifications navbar-item is-paddingless">
                            <span
                                :class="[
                                    'navbar-notification-btn',
                                    'notification-icon',
                                    notificationIconActiveClass
                                ]"
                                @click="toggleNotifications"
                                v-click-outside="hideNotifications"
                            />
                            <div v-if="notificationsDisplay" class="notifications__wrapper">
                                <ul class="notifications__list" v-if="notifications.length > 0">
                                    <li
                                        class="notifications__item"
                                        v-for="(notification, index) in notifications"
                                        :key="index"
                                    >
                                        <component
                                            :is="notificationComponent(getNotificationType(notification))"
                                            :notification="getNotificationSubject(notification)"
                                            :user="getNotificationUser(notification)"
                                        />
                                    </li>
                                </ul>
                                <div v-else class="notifications__none">
                                    {{ $t('notifications.navbar.no_notifs') }}
                                </div>
                            </div>
                        </div>
                        <div class="navbar-item has-dropdown is-hoverable">
                            <div v-if="user" class="profile navbar-link navbar-dropdown-menu">
                                <div v-if="user.avatar_url" class="profile__avatar navbar-avatar">
                                    <img
                                        :src="user.avatar_url"
                                        :title="user.first_name+' '+user.last_name"
                                        :alt="user.first_name+' '+user.last_name"
                                    >
                                </div>
                                <span v-else class="icon">
                                    <i class="fas fa-file-image fa-lg" />
                                </span>
                                <span class="profile__name">{{ user.first_name }}</span>
                            </div>
                            <div class="navbar-dropdown">
                                <router-link
                                    class="navbar-item"
                                    :to="{ name: 'OtherUserPage', params: { id: user.id } }"
                                >{{ $t('navbar.profile') }}
                                </router-link>
                                <router-link
                                    class="navbar-item"
                                    :to="{ name: 'MyTastesPage' }"
                                >{{ $t('navbar.tastes') }}
                                </router-link>
                                <router-link
                                    class="navbar-item"
                                    :to="{ name: 'UserListsPage' }"
                                >{{ $t('navbar.lists') }}
                                </router-link>
                                <router-link
                                    class="navbar-item"
                                    :to="{ name: 'CheckinsPage' }"
                                >{{ $t('navbar.visited') }}
                                </router-link>
                                <router-link
                                    class="navbar-item"
                                    :to="{ name: 'NewPlacePage' }"
                                >{{ $t('navbar.new_place') }}
                                </router-link>
                                <router-link
                                    class="navbar-item"
                                    :to="{ name: 'ProfilePage' }"
                                >{{ $t('navbar.settings') }}
                                </router-link>
                                <router-link
                                    class="navbar-item"
                                    :to="{ name: 'NotificationsPage'}"
                                >{{ $t('navbar.notifications') }}
                                </router-link>
                                <a
                                    class="navbar-item"
                                    @click="onLogOut"
                                >{{ $t('navbar.logout') }}</a>
                            </div>
                        </div>
                    </div>
                    <div class="navbar-item navbar-lang">
                        <LanguageSelector />
                    </div>
                </div>
            </div>
        </nav>

    </div>
</template>

<script>
import { mapActions, mapGetters, mapMutations, mapState } from 'vuex';
import NavbarSearchPanel from './NavbarSearchPanel';
import LanguageSelector from './LanguageSelector';

import LikeReviewNotification             from '@/components/notifications/LikeReviewNotification';
import DislikeReviewNotification          from '@/components/notifications/DislikeReviewNotification';
import FollowedUserReviewNotification     from '@/components/notifications/FollowedUserReviewNotification';
import FollowedUserAddPlaceNotification   from '@/components/notifications/FollowedUserAddPlaceNotification';
import FollowedUserAddListNotification    from '@/components/notifications/FollowedUserAddListNotification';
import FollowedUserDeleteListNotification from '@/components/notifications/FollowedUserDeleteListNotification';
import FollowedUserUpdateListNotification from '@/components/notifications/FollowedUserUpdateListNotification';
import ReviewPlaceNotification            from '@/components/notifications/ReviewPlaceNotification';
import UserFollowNotification             from '@/components/notifications/UserFollowNotification';
import UserUnfollowNotification           from '@/components/notifications/UserUnfollowNotification';
import UnknownNotification                from '@/components/notifications/UnknownNotification';
import {
    LIKE_REVIEW_NOTIFICATION,
    REVIEW_PLACE_NOTIFICATION,
    FOLLOWED_USER_REVIEW_NOTIFICATION,
    FOLLOWED_USER_ADD_PLACE_NOTIFICATION,
    DISLIKE_REVIEW_NOTIFICATION,
    USER_FOLLOW_NOTIFICATION,
    USER_UNFOLLOW_NOTIFICATION,
    FOLLOWED_USER_ADD_LIST_NOTIFICATION,
    FOLLOWED_USER_DELETE_LIST_NOTIFICATION,
    FOLLOWED_USER_UPDATE_LIST_NOTIFICATION
} from '@/services/notification/notificationService';

export default {
    name: 'TopNavbar',
    components: {
        NavbarSearchPanel,
        LanguageSelector,
        LikeReviewNotification,
        UnknownNotification,
        ReviewPlaceNotification,
        FollowedUserReviewNotification,
        FollowedUserAddPlaceNotification,
        DislikeReviewNotification,
        UserFollowNotification,
        UserUnfollowNotification,
        FollowedUserAddListNotification,
        FollowedUserDeleteListNotification,
        FollowedUserUpdateListNotification
    },
    data () {
        return {
            navIsActive: false,
            isNewNotifications: false,
            notificationsDisplay: false
        };
    },
    computed: {
        ...mapGetters({
            isUserLoggedIn: 'auth/isLoggedIn',
            user: 'auth/getAuthenticatedUser',
            getUser: 'users/getUserProfile',
            allNotifications: 'notifications/getNotifications',
            notifications: 'notifications/getUnreadNotifications',
        }),
        ...mapState('auth', ['currentUser']),
        notificationIconActiveClass() {
            return this.isNewNotifications
                ? 'notification-icon--active'
                : null;
        },
    },
    watch: {
        isUserLoggedIn: function() {
            if (this.isUserLoggedIn) {
                this.listenChannel(this.currentUser.id);
                this.getUnreadNotifications()
                    .then(() => {
                        if (!this.notificationsDisplay
                            && this.notifications.length > 0
                            && this.$route.name !== 'NotificationsPage'
                        ) {
                            this.isNewNotifications = true;
                        }
                    });
            }
        },
        '$route' () {
            this.navIsActive = false;
        }
    },
    methods: {
        ...mapActions({
            logout: 'auth/logout',
            getUnreadNotifications: 'notifications/getUnreadNotifications',
            readNotifications: 'notifications/readNotifications',
        }),
        ...mapMutations('users', {
            addUser: 'ADD_USER',
        }),
        ...mapMutations('notifications', {
            addNotification: 'ADD_NOTIFICATION',
            addUnreadNotificationId: 'ADD_UNREAD_NOTIFICATION_ID',
        }),
        onLogOut () {
            this.logout()
                .then(()=>{
                    this.$router.push({name: 'LoginPage'});
                });
        },
        toggleMenu () {
            this.navIsActive = !this.navIsActive;
        },
        toggleNotifications() {
            if (this.isNewNotifications) {
                this.isNewNotifications = false;
                this.readNotifications();
            }

            this.notificationsDisplay = !this.notificationsDisplay;
        },
        hideNotifications() {
            this.notificationsDisplay = false;
        },
        listenChannel(id) {
            Echo.private(`App.User.${id}`)
                .notification((payload) => {
                    if (!this.notificationsDisplay) {
                        this.isNewNotifications = true;
                    } else {
                        this.readNotifications();
                    }

                    if (this.$route.name !== 'NotificationsPage') {
                        this.addUnreadNotificationId(payload.id);
                    }

                    this.addNotification({
                        id: payload.id,
                        data: payload,
                        read_at: payload['read_at'],
                        created_at: {
                            date: Date.now()
                        }
                    });
                });
        },
        notificationComponent: function(type) {
            switch (type) {
            case LIKE_REVIEW_NOTIFICATION:
                return 'LikeReviewNotification';
            case REVIEW_PLACE_NOTIFICATION:
                return 'ReviewPlaceNotification';
            case FOLLOWED_USER_REVIEW_NOTIFICATION:
                return 'FollowedUserReviewNotification';
            case FOLLOWED_USER_ADD_PLACE_NOTIFICATION:
                return 'FollowedUserAddPlaceNotification';
            case DISLIKE_REVIEW_NOTIFICATION:
                return 'DislikeReviewNotification';
            case USER_FOLLOW_NOTIFICATION:
                return 'UserFollowNotification';
            case USER_UNFOLLOW_NOTIFICATION:
                return 'UserUnfollowNotification';
            case FOLLOWED_USER_ADD_LIST_NOTIFICATION:
                return 'FollowedUserAddListNotification';
            case FOLLOWED_USER_DELETE_LIST_NOTIFICATION:
                return 'FollowedUserDeleteListNotification';
            case FOLLOWED_USER_UPDATE_LIST_NOTIFICATION:
                return 'FollowedUserUpdateListNotification';
            default:
                return 'UnknownNotification';
            }
        },
        getNotificationUser(notification) {
            return notification.data.notification['subject_user'];
        },
        getNotificationSubject(notification) {
            return notification.data.notification.subject;
        },
        getNotificationType(notification) {
            return notification.data.notification.type;
        }
    },
};
</script>

<style lang="scss" scoped>
    $blue: #167df0;
    $grey: #c5c5c5;
    $dark-grey: #4a4a4a;

        .logo-top{
            margin-right: 3px;
        }

    .notification-icon {
        position: relative;

        &--active:after {
            content: "";
            display: block;
            position: absolute;
            bottom: 0;
            right: 0;
            background-color: red;
            border-radius: 50%;
            width: 10px;
            height: 10px;
        }
    }

    .notifications {
        position: relative;

        &__wrapper {
            position: absolute;
            color: $dark-grey;
            top: 38px;
            right: 0;
            border-radius: 5px;
            background-color: #fff;
            width: 300px;
            max-height: 150px;
            overflow-x: hidden;
            overflow-y: auto;
            box-shadow: 0px 3px 20px $blue;
        }

        &__item {
            border-bottom: $grey 1px solid;
            padding: 10px;
            word-break: break-word;

            &:hover {
                background-color: darken(#fff, 10%);
            }

            &:last-child {
                border-bottom: none;
            }
        }

        &__none {
            text-align: center;
            padding: 10px;
        }
    }

    .navbar-brand-name {
        text-transform: uppercase;
        font-weight: bold;
        letter-spacing: 0.2rem;
    }
    .navbar-dropdown-menu {
        padding-right: .75rem;

        &:after{
             border: none;
        }
    }
    .navbar-avatar {
        margin: 0 10px;
        width: 28px;
        height: 28px;

        img {
            border-radius:4px;
            width: 100%;
            height: 100%;
            object-fit: cover;
            object-position: 50% 50%;
        }
    }
    .navbar-notification-btn {
        cursor: pointer;
        background: url("../../assets/icon-notifications.png") top left no-repeat;
        font-weight: bold;
        height: 24px;
        width: 27px;
        align-self: center;
    }
    .navbar-burger {
        color: #fff;
    }
    .navbar-brand {
        @media screen and (max-width: 911px) {
            width: 100%;
        }
    }
    .navbar-wrapper {
        position: static; 
    }
    .navbar-wrapper.container {
        @media screen and (min-width: 912px) and (max-width: 1279px) {
            max-width: 94%;
        }
    }
    .navbar-menu {
        @media screen and (max-width: 911px) {
           position: absolute;
           right: 0;
           top: 52px;
           width: 200px;
        }
    }

    .navbar-start {        
        @media screen and (max-width: 911px) {
            margin-bottom: 10%;
        }
    }

    .navbar-end {
        padding-right: 0;

        @media screen and (max-width: 1600px) {
            padding-right: 60px;
        }

        @media screen and (max-width: 911px) {
            padding-right:0;

            .profile {
                display: none;
            }
        }
    }

    .navbar-dropdown-menu {
        padding-right: 20px;

        @media screen and (max-width: 911px) {
           text-align: center;
        }

        &:after {
            content: '\f0d7';
            font-family: 'Font Awesome 5 Free';
            font-weight: 900;
            position: absolute;
            top: 20px;
            right: 5px;
            display: inline-block;
            transform: rotate(0deg);

            @media screen and (max-width: 911px) {
                display: none;
            }
        }
    }

    .navbar-lang {
        position:absolute;
        right:0px;

        @media screen and (max-width: 911px) {
            height: 60px;
            position:static;
            padding: 0;
            overflow: hidden;
        }
    }

</style>
