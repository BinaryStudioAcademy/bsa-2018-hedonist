<template>
    <div>
        <Preloader :active="isLoading" />
        <template v-if="!isLoading">
            <div v-if="!userProfile.is_private || userProfile.id === getAuthenticatedUser.id">
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
            </div>
            <div v-else>
                <PrivateProfile />
            </div>
        </template>
    </div>
</template>

<script>
import {mapActions, mapGetters} from 'vuex';
import Preloader from '@/components/misc/Preloader';
import GeneralInfo from '@/components/users/GeneralInfo';
import ListsContainer from '@/components/users/ListsContainer';
import ReviewsContainer from '@/components/users/ReviewsContainer';
import PrivateProfile from '@/components/users/PrivateProfile';
import {otherUserPage} from '@/services/common/pageConstants';
import FollowersContainer from '../components/users/FollowersContainer';
import FollowedContainer from '../components/users/FollowedContainer';

export default {
    name: 'OtherUserPage',
    components: {
        PrivateProfile,
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
            pageConstants: otherUserPage,
            userProfile: {
                is_private: true
            }
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
    computed: {
        ...mapGetters('users', ['getUserProfile']),
        ...mapGetters('auth', ['getAuthenticatedUser'])
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
            this.$store.dispatch('users/getUsersProfile', userId)
                .then(() => {
                    this.userProfile = this.getUserProfile(this.$route.params.id);
                    if (!this.userProfile.is_private || this.userProfile.id === this.getAuthenticatedUser.id ) {
                        Promise.all([
                            this.$store.dispatch('userList/getListsByUser', userId),
                            this.$store.dispatch('users/fetchReviewsWithPlaceByUser', userId),
                        ])
                            .then(() => {
                                this.isLoading = false;
                            });
                    } else {
                        this.isLoading = false;
                    }
                })
                .catch(() => {
                    this.$router.push({
                        name: 'SearchPlacePage'
                    });
                });
        }
    }
};
</script>

<style scoped>

</style>