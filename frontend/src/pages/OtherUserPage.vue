<template>
    <div>
        <Preloader :active="isLoading" />
        <div v-if="!userProfile.is_private">
            <GeneralInfo />
            <ListsContainer />
            <ReviewsContainer />
        </div>
        <div v-else>
            <PrivateProfile />
        </div>
    </div>
</template>

<script>
import {mapActions, mapGetters} from 'vuex';
import Preloader from '@/components/misc/Preloader';
import GeneralInfo from '@/components/users/GeneralInfo';
import ListsContainer from '@/components/users/ListsContainer';
import ReviewsContainer from '@/components/users/ReviewsContainer';
import PrivateProfile from '@/components/users/PrivateProfile';

export default {
    name: 'OtherUserPage',
    components: {
        PrivateProfile,
        Preloader,
        GeneralInfo,
        ListsContainer,
        ReviewsContainer
    },
    data(){
        return{
            isLoading: true,
            loadingTime: 2000
        };
    },
    created() {
        this.$store.dispatch('users/getUsersProfile', this.$route.params.id)
            .then(() => {
                this.isLoading = false;
            });
    },
    loaded: function() {
        return !(this.isLoading);
    },
    computed: {
        ...mapGetters({
            userProfile: 'users/getUserProfile'
        })
    }
};
</script>

<style scoped>

</style>