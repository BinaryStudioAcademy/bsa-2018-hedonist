<template>
        <div class="columns is-mobile">
            <div class="column is-4">
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
    import UserList from '@/components/user-list/UserList'

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
    #map {
        text-align: justify;
        position: fixed;
        top: 52px;
        bottom: 0;
        right: 0;
        width: 66%;
    }

    .columns {
        padding-left: 10px;
        padding-right: 10px;
    }
</style>