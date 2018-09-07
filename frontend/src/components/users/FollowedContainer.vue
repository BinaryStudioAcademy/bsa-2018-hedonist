<template>
    <div class="container">
        <h3 class="subtitle is-4">{{ userProfile.first_name }}'s followed users</h3>
        <FollowersList :users="followers" />
    </div>
</template>

<script>
import FollowersList from './FollowersList';
import {mapGetters,mapState} from 'vuex';

export default {
    name: 'FollowedContainer',
    components: {FollowersList},
    computed:{
        ...mapGetters('users',['getUserProfile']),
        ...mapState('users', ['users']),
        userProfile(){
            return this.getUserProfile(this.$route.params.id);
        },
        followers(){
            return this.userProfile.followedUsers.map((id) => this.users.byId[id]);
        }
    }
};
</script>

<style scoped>

</style>