<template>
    <div class="wrapper">
        <div class="columns">
            <div class="column is-half">
                <div class="page-content" v-if="!isLoading">
                    <ListHeader
                            :listItem="userList"
                    />
                    <ListPlaceItem
                            v-for="place in denormolizedPlaces"
                            :key="place.id"
                            :place="place"
                    />
                </div>
            </div>
        </div>
    </div>
</template>

<script>
    import {mapGetters, mapActions, mapState} from 'vuex'
    import ListHeader from "../components/userList/ListHeader";
    import ListPlaceItem from "../components/userList/ListPlaceItem";

    export default {
        name: "UserListPage",
        components: {ListPlaceItem, ListHeader},
        created() {
            this.getListById(this.$route.params.id);
        },
        methods: {
            ...mapActions('userList', ['getListById'])
        },
        computed: {
            ...mapGetters('userList', ['getById']),
            ...mapState('userList', ['isLoading', 'places']),
            userList() {
                return this.getById(this.$route.params.id);
            },
            denormolizedPlaces() {
                const places = [];
                for (const index of this.userList.places) {
                    places.push(this.places.byId[index]);
                }
                return places;
            }
        }
    }
</script>

<style lang="scss" scoped>
    .wrapper {
        padding: 10px 20px;
    }
</style>