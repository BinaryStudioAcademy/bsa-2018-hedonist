<template>
    <div class="container">
        <div class="user-reviews-container">
            <div class="user-reviews-header">
                <h3 class="subtitle is-4">{{ userProfile.first_name }}'s {{$t('other_user_page.review_container.title')}}</h3>
            </div>
            <ul class="columns is-variable is-4 is-multiline user-reviews-items">
                <template v-for="place in filteredUsersPlaces">
                    <ReviewsContainerItem
                        :key="place.id"
                        :place="place"
                    />
                </template>
            </ul>
        </div>
    </div>
</template>

<script>
import {mapState, mapActions, mapGetters} from 'vuex';
import ReviewsContainerItem from '@/components/users/ReviewsContainerItem';

export default {
    name: 'ReviewsContainer',
    data() {
        return {};
    },
    components: {
        ReviewsContainerItem
    },
    computed: {
        ...mapState('place', {
            places: 'places',
        }),
        ...mapGetters('users',['getUserProfile']),
        ...mapGetters('place', ['getReviewsById' , 'getUserReviewsAll']),
        filteredUsersPlaces: function () {
            return this.getReviewsById(parseInt(this.$route.params.id));
        },
        filterAllReviewUser: function () {
            return this.getUserReviewsAll(parseInt(this.$route.params.id)).length;
        },
        userProfile(){
            return this.getUserProfile(this.$route.params.id) || {};
        },
        userName(){
            return this.userProfile.first_name || '';
        }
    },
};
</script>
<style scoped>
    .user-reviews-container{
        margin-top: 30px;
    }
</style>
