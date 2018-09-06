<template>
    <div>
        <Preloader
                :active="isLoading"
        />
        <GeneralInfo
            :currentTab="currentTab"
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
    </div>
</template>

<script>
    import {mapActions} from 'vuex';
    import Preloader from '@/components/misc/Preloader';
    import GeneralInfo from '@/components/users/GeneralInfo';
    import ListsContainer from '@/components/users/ListsContainer';
    import ReviewsContainer from '@/components/users/ReviewsContainer';
    import {otherUserPage} from "@/services/common/pageConstants";
    import FollowersContainer from "../components/users/FollowersContainer";

    export default {
        name: 'OtherUserPage',
        components: {
            FollowersContainer,
            Preloader,
            GeneralInfo,
            ListsContainer,
            ReviewsContainer
        },
        data() {
            return {
                isLoading: true,
                loadingTime: 2000,
                currentTab: otherUserPage.listTab,
                pageConstants: otherUserPage
            };
        },
        created() {
            setTimeout(() => {
                Promise.all([
                    this.$store.dispatch('users/getUsersProfile', this.$route.params.id),
                    this.$store.dispatch('userList/getListsByUser', this.$route.params.id),
                    this.$store.dispatch('place/fetchPlaces', this.$route.query)
                ])
                    .then(() => {
                        this.isLoading = false;
                    });
            }, this.loadingTime);
        },
        loaded: function () {
            return !(this.isLoading);
        },
        methods:{
            changeTab(tab){
                this.currentTab = tab;
            },
            activeTab(tab){
                return this.currentTab === tab;
            }
        }
    };
</script>

<style scoped>

</style>