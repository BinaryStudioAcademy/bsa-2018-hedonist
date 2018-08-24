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
                        <div class="navbar-item is-paddingless">
                            <span class="navbar-notification-btn" />
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
                                    :to="{ name: 'MyTastesPage' }"
                                >My tastes</router-link>
                                <router-link
                                    class="navbar-personal-link navbar-item"
                                    :to="{ name: 'UserListsPage' }"
                                >My lists
                                </router-link>
                                <router-link
                                    class="navbar-personal-link navbar-item"
                                    :to="{ name: 'HistoryPage' }"
                                >History
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
            navIsActive: false
        };
    },
    computed: {
        ...mapGetters({
            isUserLoggedIn: 'auth/isLoggedIn',
            user: 'auth/getAuthenticatedUser'
        })
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
        }
    },
    components: {
        NavbarSearchPanel,
        LanguageSelector
    }
};
</script>

<style lang="scss" scoped>
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
        margin-left: 7px;
    }

</style>
