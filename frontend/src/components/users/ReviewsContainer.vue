<template>
    <div class="container">
        <div class="user-reviews-container">
            <div class="user-reviews-header">
                <h3 class="subtitle is-4">{{ userProfile.first_name }}'s {{ $t('other_user_page.review_container.title') }}</h3>
            </div>
            <ul class="columns is-variable is-4 is-multiline user-reviews-items">
                <template v-for="review in getUserReviews">
                    <ReviewsContainerItem
                        :key="review.id"
                        :review="review"
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
        ...mapGetters('users',['getUserProfile', 'getUserReviews']),
        ...mapGetters('place', ['getReviewsById' , 'getUserReviewsAll']),
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
