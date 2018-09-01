<template>
    <div>
        <GeneralInfo
            :reviews-count="filterAllReviewUser.length"
        />

        <ListsContainer />

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
        filteredUsersPlaces: function () {
            return this.getReviewsById(parseInt(this.$route.params.id));
        },
        filterAllReviewUser: function () {
            return this.getUserReviewsAll(parseInt(this.$route.params.id));
        },
    },
    created() {
        this.$store.dispatch('place/fetchPlaces', this.$route.query);
    },
};
</script>

<style scoped>

</style>