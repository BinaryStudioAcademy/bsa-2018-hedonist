<template>
    <div class="columns placeholder">
        <div class="column is-5">
            <UserList
                    class="list"
                    :places="places"
                    :list="list"
            />
        </div>
            <section id="map">
                <mapbox
                        :access-token="getMapboxToken"
                        :map-options="{
                        style: getMapboxStyle,
                        zoom: 3
                    }"
                        :scale-control="{
                        show: true,
                        position: 'top-left'
                    }"
                        :fullscreen-control="{
                        show: true,
                        position: 'top-left'
                    }"
                />
            </section>
        </div>
</template>

<script>
    import {mapState} from "vuex";
    import {mapGetters} from "vuex"
    import Mapbox from 'mapbox-gl-vue';
    import UserList from '@/components/userPlacesList/UserList'

    export default {
        name: "UserListOnMapPage",
        components: {UserList, Mapbox},

        computed: {
            ...mapState("userList", ["places", "list"]),
            ...mapGetters("map", ["getMapboxToken", "getMapboxStyle"]),
        }
    }
</script>

<style lang="scss" scoped>
    .placeholder {
        padding-top: 0.5rem;
        background: #DDD;
    }

    #map {
        text-align: justify;
        position: fixed;
        top: 52px;
        bottom: 0;
        right: 0;
        width: 58%;
    }

    .columns {
        padding-left: 10px;
        padding-right: 10px;
    }

    @media screen and (max-width: 769px) {
        #map {
            text-align: justify;
            vertical-align: top;
            position: relative;
            top: 0;
            left: 0;
            width: 100%;
            height: 500px;
            order:-1;
        }
    }

</style>