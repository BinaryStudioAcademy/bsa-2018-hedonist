<template>
    <div class="container">
        <h3 class="subtitle is-4 followers-header">
            <template v-if="$i18n.locale() === 'en'">
                {{ userProfile.first_name }}'s
                {{ $t('other_user_page.follower_container.title') }}
            </template>
            <template v-else>
                {{ $t('other_user_page.follower_container.title') }}
                {{ userProfile.first_name }}
            </template>
        </h3>
        <FollowersList :users="followers" />
    </div>
</template>

<script>
import {mapGetters,mapState} from 'vuex';
import FollowersList from './FollowersList';

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

<style lang="scss" scoped>
    .followers-header{
        margin-top: 30px;
    }

    .container {
        @media screen and (max-width: 911px) {
            margin: 0 20px;
        }

        @media screen and (max-width: 768px) {
            .subtitle {
                text-align: center;
            }
        }
    }
</style>