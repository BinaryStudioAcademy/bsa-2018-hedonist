<template>
    <div id="app">
        <nav class="navigation">
            <ul class="navbar">
                <li><router-link to="/">Home</router-link></li>
                <li><router-link to="/profile">Profile</router-link></li>
                <li><router-link to="/place-info">Place-info</router-link></li>
                <li><router-link to="/places/list">Place-list</router-link></li>
            </ul>
        </nav>
        <router-view/>
    </div>
</template>

<script>
export default {
    name: 'App'
}
</script>

<style>
@import url(buefy/lib/buefy.css);

#app {
    font-family: 'Avenir', Helvetica, Arial, sans-serif;
    -webkit-font-smoothing: antialiased;
    -moz-osx-font-smoothing: grayscale;
    color: #4e595d;
    background-color: #efeff4;
}

.navigation .navbar li {
    line-height: 50px;
    margin-right: 15px;
}
</style>
