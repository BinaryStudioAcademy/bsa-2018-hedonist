<template>
    <div class="container">
        <h3 class="subtitle is-4">{{ userProfile.first_name }}'s followers</h3>
        <UserList :users="followers" />
    </div>
</template>

<script>
    import UserList from "./UserList";
    import {mapGetters,mapState} from 'vuex'
    export default {
        name: "FollowersContainer",
        components: {UserList},
        computed:{
            ...mapGetters('users',['getUserProfile']),
            ...mapState('users', ['users']),
            userProfile(){
                return this.getUserProfile(this.$route.params.id);
            },
            followers(){
                return this.userProfile.followers.map((id) => this.users.byId[id]);
            }
        }
    }
</script>

<style scoped>

</style>