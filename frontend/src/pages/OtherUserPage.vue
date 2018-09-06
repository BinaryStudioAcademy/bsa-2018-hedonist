<template>
    <div>
        <Preloader
            :active="isLoading"
        />
        <template v-if="!isLoading">
            <GeneralInfo
                :current-tab="currentTab"
                @tabChanged="changeTab"
            />
            <ListsContainer
                v-if="activeTab(pageConstants.listTab)"
            />
            <ReviewsContainer
                v-if="activeTab(pageConstants.reviewTab)"
            />
            <FollowersContainer
                v-if="activeTab(pageConstants.followersTab)"
            />
            <FollowedContainer
                v-if="activeTab(pageConstants.followedTab)"
            />
        </template>
    </div>
</template>

<script>
import {mapActions} from 'vuex';
import Preloader from '@/components/misc/Preloader';
import GeneralInfo from '@/components/users/GeneralInfo';
import ListsContainer from '@/components/users/ListsContainer';
import ReviewsContainer from '@/components/users/ReviewsContainer';
import {otherUserPage} from '@/services/common/pageConstants';
import FollowersContainer from '../components/users/FollowersContainer';
import FollowedContainer from '../components/users/FollowedContainer';

export default {
    name: 'OtherUserPage',
    components: {
        FollowedContainer,
        FollowersContainer,
        Preloader,
        GeneralInfo,
        ListsContainer,
        ReviewsContainer
    },
    data() {
        return {
            isLoading: true,
            currentTab: otherUserPage.listTab,
            pageConstants: otherUserPage
        };
    },
    created() {
        this.load(this.$route.params.id);
    },
    beforeRouteUpdate (to, from, next) {
        this.load(to.params.id);
        this.currentTab = otherUserPage.listTab;
        next();
    },
    loaded: function () {
        return !(this.isLoading);
    },
    methods: {
        changeTab(tab) {
            this.currentTab = tab;
        },
        activeTab(tab) {
            return this.currentTab === tab;
        },
        load(userId){
            this.isLoading = true;
            Promise.all([
                this.$store.dispatch('users/getUsersProfile', userId),
                this.$store.dispatch('userList/getListsByUser', userId),
                this.$store.dispatch('place/fetchPlaces', this.$route.query)
            ])
                .then(() => {
                    this.isLoading = false;
                });
        }
    }
};
</script>

<style scoped>

</style>