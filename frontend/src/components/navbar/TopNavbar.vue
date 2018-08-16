<template>
    <div class="is-paddingless">
        <nav class="navbar is-info">
            <div class="navbar-wrapper container is-flex">
                <div class="navbar-brand navbar-brand-name">
                    <router-link
                        class="navbar-item"
                        to="/"
                    >Hedonist</router-link>
                </div>

                <div class="navbar-menu">
                    <search-input v-if="isUserLoggedIn" />
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
                                <span class="icon">
                                    <i class="fas fa-caret-down" />
                                </span>
                            </div>
                            <div class="navbar-dropdown">
                                <router-link
                                    class="navbar-item"
                                    :to="{ name: 'ProfilePage' }"
                                >Profile</router-link>
                                <router-link
                                    class="navbar-personal-link navbar-item"
                                    :to="{ name: 'PlacesList' }"
                                >My places</router-link>
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
                </div>
            </div>
        </nav>

    </div>
</template>

<script>
import { mapActions, mapGetters } from 'vuex';
import SearchInput from './SearchInput';

export default {
    name: 'TopNavbar',
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
        }
    },
    components: {
        SearchInput
    }
};
</script>

<style lang="scss" scoped>
    .navbar-brand-name{
        text-transform: uppercase;
        font-weight: bold;
        letter-spacing: 0.2rem;
    }
    .navbar-search-btn{
        cursor:pointer;
    }
    .navbar-dropdown-menu{
        padding-right: .75rem;
        &:after{
            border: none;
        }
    }
    .navbar-personal-link{
        text-indent: 15px;
    }
    .navbar-avatar{
        margin:0 10px;
        border-radius:4px;
    }
    .navbar-notification-btn{
        cursor:pointer;
        background: url("../../assets/icon-notifications.png") top left no-repeat;
        font-weight: bold;
        height: 24px;
        width: 27px;
        align-self: center;
    }
</style>