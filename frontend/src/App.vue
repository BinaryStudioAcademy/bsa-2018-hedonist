<template>
    <div id="app">
        <TopNavbar/>

        <router-view/>
    </div>
</template>

<script>
    import TopNavbar from './components/navbar/TopNavbar';

    export default {
        name: 'App',
        components:{
            TopNavbar
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
</style>
