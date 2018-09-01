<template>
    <div>
        <GeneralInfo
            :reviews-count="filterAllReviewUser.length"
        />

        <div class="container user-cities">
            <h3 class="subtitle is-4">{{ userProfile.first_name }}'s lists</h3>
            <ul class="columns is-variable is-4 is-multiline user-cities-items">
                <ListsContainer
                    v-for="userList in filteredUserLists"
                    :key="userList.id"
                    :user-list="userList"
                />
            </ul>
        </div>

        <div class="container">
            <div class="user-reviews-container">
                <div class="user-reviews-header">
                    <h3 class="subtitle is-4">{{ userProfile.first_name }}'s recent reviews</h3>
                    <div class="header-btn">
                        <a class="button is-info">
                            <span>See all {{ filterAllReviewUser.length }} reviews</span>
                        </a>
                    </div>
                </div>
                <ul class="columns is-variable is-4 is-multiline user-reviews-items">
                    <template v-for="place in filteredUsersPlaces">
                        <ReviewsContainer
                            :key="place.id"
                            :place="place"
                        />
                    </template>
                </ul>
            </div>
        </div>

    </div>
</template>

<script>
import {mapState, mapActions, mapGetters} from 'vuex';
import GeneralInfo from '@/components/users/GeneralInfo';
import ListsContainer from '@/components/users/ListsContainer';
import ReviewsContainer from '@/components/users/ReviewsContainer';

export default {
    name: 'OtherUserPage',
    components: {
        GeneralInfo,
        ListsContainer,
        ReviewsContainer
    },
    data(){
        return{

        };
    },
    computed: {
        ...mapState('place', {
            places: 'places',
        }),
        ...mapGetters({
            userProfile: 'users/getUserProfile'
        }),
        ...mapGetters('place', ['getReviewsById' , 'getUserReviewsAll']),
        ...mapState('userList', [
            'userLists'
        ]),
        filteredUserLists: function () {
            return this.userLists ? this.userLists.byId : null;
        },
        filteredUsersPlaces: function () {
            return this.getReviewsById(parseInt(this.$route.params.id));
        },
        filterAllReviewUser: function () {
            return this.getUserReviewsAll(parseInt(this.$route.params.id));
        },
    },
    filters: {
        countUserLists: function (lists) {
            return lists.length;
        },
    },
    created() {
        this.getUsersLists(this.$route.params.id);
        this.$store.dispatch('place/fetchPlaces', this.$route.query);
    },
    methods: {
        ...mapActions({
            getUsersLists: 'userList/getListsByUser',
        }),
    },
};
</script>

<style scoped>

</style>