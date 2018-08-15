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
                    <div class="navbar-start">
                        <div class="navbar-item">
                            <div class="control has-icons-right">
                                <input 
                                    class="input" 
                                    type="search" 
                                    placeholder="I'm looking for..."
                                >
                                <span class="icon is-right">
                                    <i class="fas fa-caret-down" />
                                </span>
                            </div>
                        </div>
                        <div class="navbar-item">
                            <div class="control">
                                <input 
                                    class="input" 
                                    type="search" 
                                    value="Lviv, UA"
                                >
                            </div>
                        </div>
                        <div class="navbar-item is-paddingless navbar-search-btn">
                            <span class="icon is-large">
                                <i class="fas fa-lg fa-search" />
                            </span>
                        </div>

                    </div>

                    <div 
                        v-if="!this.isUserLoggedIn" 
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
                        v-if="this.isUserLoggedIn"
                        class="navbar-end"
                    >
                        <div class="navbar-item is-paddingless">
                            <span class="navbar-notification-btn" />
                        </div>
                        <div class="navbar-item has-dropdown is-hoverable">
                            <div class="navbar-link navbar-dropdown-menu">
                                <img 
                                    v-if="user.avatar_url"
                                    class="navbar-avatar" 
                                    :src="user.avatar_url"
                                    :title="user.first_name+' '+user.last_name"
                                    :alt="user.first_name+' '+user.last_name"
                                >
                                <span v-else class="icon">
                                    <i class="fas fa-file-image fa-lg"></i>
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

export default {
    name: 'TopNavbar',
    computed: mapGetters({
        isUserLoggedIn: 'auth/hasToken',
        user: 'auth/getAuthenticatedUser'
    }),
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
};
</script>

<style scoped>
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