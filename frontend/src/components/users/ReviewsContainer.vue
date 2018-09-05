<template>
    <div class="container">
        <div class="user-reviews-container">
            <div class="user-reviews-header">
                <h3 class="subtitle is-4">{{ userProfile.first_name }}'s recent reviews</h3>
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
        ...mapGetters({
            userProfile: 'users/getUserProfile'
        }),
        ...mapGetters('place', ['getReviewsById' , 'getUserReviewsAll']),
        filteredUsersPlaces: function () {
            console.log(this.getReviewsById(parseInt(this.$route.params.id)));
            return this.getReviewsById(parseInt(this.$route.params.id));
        },
    },
    created() {
        this.$store.dispatch('place/fetchPlaces', this.$route.query);
    },

};
</script>
<style >

    </style>
