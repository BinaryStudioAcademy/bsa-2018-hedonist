<template>
    <div class="container">
        <h3 class="subtitle is-4">{{ userProfile.first_name }}'s followers</h3>
        <FollowersList :users="followers" />
    </div>
</template>

<script>
import {mapGetters,mapState} from 'vuex';
import FollowersList from "./FollowersList";

export default {
    name: 'FollowersContainer',
    components: {FollowersList},
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
};
</script>

<style scoped>

</style>