<template>
   <div id="app">
        <nav class="navigation">
            <ul class="navbar">
                <li><router-link to="/">Home</router-link></li>
                <li><router-link to="/signup">Sign up</router-link></li>
                <li><router-link to="/login">Login</router-link></li>
                <li><a @click="onLogOut">Logout</a></li>
                <li><router-link to="/profile">Profile</router-link></li>
                <li><router-link to="/place-info">Place-info</router-link></li>
                <li><router-link to="/places/list">Place-list</router-link></li>
                <li><router-link to="/tastes/add">Tastes add</router-link></li>
                <li><router-link to="/user/lists">User lists</router-link></li>
            </ul>
        </nav>
        <router-view/>
    </div>
</template>

<script>
import { mapActions } from 'vuex'

export default {
    name: 'App',

    methods: {
        ...mapActions(['logout']),

        onLogOut () {
            this.logout();
        }
    }
}
</script>

<style lang="scss">
@import url(buefy/lib/buefy.css);
@import url('https://api.tiles.mapbox.com/mapbox-gl-js/v0.47.0/mapbox-gl.css');
@import url('https://fonts.googleapis.com/css?family=Roboto:400,500');

$background-color: #efeff4;
$font-color: #4e595d;

html, body {
    padding: 0;
    margin: 0;
    width: 100%;
    height: 100%;
    font-family: Roboto, sans-serif;
    font-size: 16px;
    font-weight: 400;
    color: $font-color;
    background-color: $background-color;
    -webkit-font-smoothing: antialiased;
    -moz-osx-font-smoothing: grayscale;
}

.navigation .navbar li {
    line-height: 50px;
    margin-right: 15px;
}
</style>
