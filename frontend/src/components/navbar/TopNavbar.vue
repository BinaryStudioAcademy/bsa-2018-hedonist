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

                <NewNotificationsList
                    class="notifications-mobile"
                    :is-new-notifications="isNewNotifications"
                    :notifications-display="notificationsDisplay"
                    @toggleNotifications="toggleNotifications"
                    @hideNotifications="hideNotifications"
                />

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
                        <NewNotificationsList
                            class="notifications-desktop"
                            :is-new-notifications="isNewNotifications"
                            :notifications-display="notificationsDisplay"
                            @toggleNotifications="toggleNotifications"
                            @hideNotifications="hideNotifications"
                        />
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
import NewNotificationsList from './NewNotificationsList';

export default {
    name: 'TopNavbar',
    components: {
        NavbarSearchPanel,
        LanguageSelector,
        NewNotificationsList,
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
                        if (!this.notificationsDisplay && this.notifications.length > 0) {
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
        toggleNotifications: _.debounce(function () {
            if (this.isNewNotifications) {
                this.isNewNotifications = false;
                this.readNotifications();
            }

            this.notificationsDisplay = !this.notificationsDisplay;
        }, 250),
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

                    this.addUnreadNotificationId(payload.id);
                    this.addNotification({
                        id: payload.id,
                        data: payload,
                        read_at: payload['read_at'],
                        created_at: {
                            date: Date.now()
                        }
                    });
                });
        }
    },
};
</script>

<style lang="scss" scoped>
    $blue: #167df0;
    $grey: #c5c5c5;
    $dark-grey: #4a4a4a;

    .logo-top {
        margin-right: 3px;
    }

    .notifications-desktop {
        display: flex;

        @media screen and (max-width: 911px) {
            display: none;
        }
    }

    .notifications-mobile {
        display: none;

        @media screen and (max-width: 911px) {
            display: flex;
            right: 80px;
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

        @media screen and (max-width: 911px) {
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
        padding-left: 0;

        @media screen and (max-width: 911px) {
            height: 60px;
            position:static;
            padding: 0;
            overflow: hidden;
        }
    }

</style>
