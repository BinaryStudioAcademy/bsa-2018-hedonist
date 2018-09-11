<template>
    <div class="container">
        <h3 class="subtitle is-4 followed-header">
            <template v-if="$i18n.locale() === 'en'">
                {{ userProfile.first_name }}'s
                {{ $t('other_user_page.followed_container.title') }}
            </template>
            <template v-else>
                {{ $t('other_user_page.followed_container.title') }}
                {{ userProfile.first_name }}
            </template>
        </h3>
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

<style lang="scss" scoped>
    .followed-header{
        margin-top: 30px;

        @media screen and (max-width: 768px) {
            text-align: center;
        }
    }
    .container {
        @media screen and (max-width: 911px) {
            margin-left: 1rem;
            margin-right: 1rem;
        }
    }
</style>