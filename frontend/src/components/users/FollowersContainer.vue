<template>
    <div class="container">
        <h3 class="subtitle is-4 followers-header">{{ userProfile.first_name }}'s {{$t('other_user_page.follower_container.title')}}</h3>
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
    .followers-header{
        margin-top: 30px;
    }
</style>