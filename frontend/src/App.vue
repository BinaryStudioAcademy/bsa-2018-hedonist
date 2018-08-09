<template>
    <div id="app">
        <link rel="stylesheet"
            href="https://use.fontawesome.com/releases/v5.2.0/css/all.css"
            integrity="sha384-hWVjflwFxL6sNzntih27bfxkr27PmbbK/iSvJ+a4+0owXq79v+lsFkW54bOGbiDQ"
            crossorigin="anonymous">
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
    margin-top: 60px;
}

.navigation .navbar li {
    margin-right: 15px;
}
</style>
