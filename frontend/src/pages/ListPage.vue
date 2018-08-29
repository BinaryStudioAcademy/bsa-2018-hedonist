<template>
    <div class="wrapper">
        <div class="columns">
            <div class="column is-half">
                <ListHeader
                        v-if="!isLoading"
                        :listItem="userList"
                />
            </div>
        </div>
    </div>
</template>

<script>
    import {mapGetters, mapActions, mapState} from 'vuex'
    import ListHeader from "../components/userList/ListHeader";

    export default {
        name: "UserListPage",
        components: {ListHeader},
        created() {
            this.getListById(this.$route.params.id);
        },
        methods: {
            ...mapActions('userList', ['getListById'])
        },
        computed: {
            ...mapGetters('userList', ['getById']),
            ...mapState('userList', ['isLoading']),
            userList() {
                return this.getById(this.$route.params.id);
            }
        }
    }
</script>

<style lang="scss" scoped>
    .wrapper{
        padding: 10px 20px;
    }
</style>