<template>
    <div class="is-paddingless">
        <nav class="navbar is-info is-fixed-top">
            <div class="navbar-wrapper container is-flex">
                <div class="navbar-brand navbar-brand-name">
                    <router-link
                        class="navbar-item"
                        to="/"
                    >Hedonist</router-link>

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
                        >Log In</router-link>
                        <router-link
                            class="navbar-item"
                            to="/signup"
                        >Sign Up</router-link>
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
                                        {{ notification }}
                                    </li>
                                </ul>
                                <div v-else class="notifications__none">
                                    No notifications for you
                                </div>
                            </div>
                        </div>
                        <div class="navbar-item has-dropdown is-hoverable">
                            <div v-if="user" class="navbar-link navbar-dropdown-menu">
                                <img
                                    v-if="user.avatar_url"
                                    class="navbar-avatar"
                                    :src="user.avatar_url"
                                    :title="user.first_name+' '+user.last_name"
                                    :alt="user.first_name+' '+user.last_name"
                                >
                                <span v-else class="icon">
                                    <i class="fas fa-file-image fa-lg" />
                                </span>
                                <span>{{ user.first_name }}</span>
                            </div>
                            <div class="navbar-dropdown">
                                <router-link
                                    class="navbar-item"
                                    :to="{ name: 'ProfilePage' }"
                                >Profile</router-link>
                                <router-link
                                    class="navbar-personal-link navbar-item"
                                    :to="{ name: 'NewPlacePage' }"
                                >Add place</router-link>
                                <router-link
                                    class="navbar-personal-link navbar-item"
                                    :to="{ name: 'MyTastesPage' }"
                                >My tastes</router-link>
                                <router-link
                                    class="navbar-personal-link navbar-item"
                                    :to="{ name: 'UserListsPage' }"
                                >My lists
                                </router-link>
                                <router-link
                                    class="navbar-personal-link navbar-item"
                                    :to="{ name: 'CheckinsPage' }"
                                >Visited
                                </router-link>
                                <a
                                    class="navbar-item"
                                    @click="onLogOut"
                                >Logout</a>
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
import { mapActions, mapGetters } from 'vuex';
import NavbarSearchPanel from './NavbarSearchPanel';
import LanguageSelector from './LanguageSelector';

export default {
    name: 'TopNavbar',
    data () {
        return {
            navIsActive: false,
            isNewNotifications: false,
            notificationsDisplay: false,
            notifications: []
        };
    },
    computed: {
        ...mapGetters({
            isUserLoggedIn: 'auth/isLoggedIn',
            user: 'auth/getAuthenticatedUser'
        }),
        notificationIconActiveClass() {
            return this.isNewNotifications
                ? 'notification-icon--active'
                : null;
        }
    },
    watch: {
        'user': function() {
            if (this.user.id) {
                window.Echo.channel(`App.User.${this.user.id}`)
                    .listen('Review.LikeAddEvent', (payload) => {
                        console.log(payload.message);
                        if (!this.notificationsDisplay) {
                            this.isNewNotifications = true;
                        }

                        this.notifications.push(payload.message);
                    });
            }
        }
    },
    methods: {
        ...mapActions({
            logout: 'auth/logout'
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
            this.isNewNotifications = false;
            this.notificationsDisplay = !this.notificationsDisplay;
        },
        hideNotifications() {
            this.notificationsDisplay = false;
        }
    },
    components: {
        NavbarSearchPanel,
        LanguageSelector
    },
    created() {
        // window.Echo.private(`Entities.User.User.1`)
        //     .notification((notification) => {
        //         console.log(notification);
        //     });
        window.Echo.channel('my-channel').listen('.my-event', (payload) => {
            console.log(payload);
        });
    },
};
</script>

<style lang="scss" scoped>
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
            padding: 10px;
            top: 38px;
            right: 0;
            color: black;
            border: 1px solid black;
            border-top: none;
            border-bottom-left-radius: 5px;
            border-bottom-right-radius: 5px;
            background-color: #fff;
            width: 300px;
            max-height: 150px;
            overflow: auto;
        }

        &__item {
            border-bottom: 1px solid black;

            &:last-child {
                border-bottom: none;
            }
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
    .navbar-personal-link {
        text-indent: 15px;
    }
    .navbar-avatar {
        margin:0 10px;
        border-radius:4px;
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
        @media screen and (max-width: 1087px) {
            width: 100%;
        }
    }
    .navbar-wrapper {
        position: static;
    }
    .navbar-menu {
        @media screen and (max-width: 1087px) {
           position: absolute;
           right: 0;
           top: 52px;
           width: 200px;
        }
    }

    .navbar-start {
        @media screen and (max-width: 1087px) {
           margin-bottom: 10%;
        }
    }

    .navbar-end {
        padding-right:0;

        @media screen and (max-width: 1600px) {
            padding-right:50px;
        }

        @media screen and (max-width: 1087px) {
            padding-right:0;
        }
    }

    .navbar-dropdown-menu {
        padding-right: 20px;

        @media screen and (max-width: 1087px) {
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

            @media screen and (max-width: 1087px) {
                display: none;
            }
        }
    }

    .navbar-dropdown > a {
        @media screen and (max-width: 1087px) {
            text-indent: 36px;
        }
    }

    .navbar-lang {
        position:absolute;
        right:0px;

        @media screen and (max-width: 1087px) {
            height: 60px;
            position:static;
            padding: 0;
            overflow: hidden;
        }
    }

</style>
