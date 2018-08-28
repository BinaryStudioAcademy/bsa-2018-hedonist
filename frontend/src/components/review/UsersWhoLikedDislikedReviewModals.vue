<template>
    <section>
        <b-modal
            :v-if="!isUsersModalLoading"
            :active.sync="usersWhoLikedReviewModalActive"
            has-modal-card
        >
            <UsersWhoLikedDislikedReviewModal
                :users="usersWhoLikedReview"
                action="liked"
                @close="close"
            />
        </b-modal>
        <b-modal
            :v-if="!isUsersModalLoading"
            :active.sync="usersWhoDislikedReviewModalActive"
            has-modal-card
        >
            <UsersWhoLikedDislikedReviewModal
                :users="usersWhoDislikedReview"
                action="disliked"
                @close="close"
            />
        </b-modal>
    </section>
</template>

<script>
import { mapState } from 'vuex';
import UsersWhoLikedDislikedReviewModal from '@/components/review/UsersWhoLikedDislikedReviewModal';

export default {
    name: 'UsersWhoLikedDislikedReviewModals',

    components: {
        UsersWhoLikedDislikedReviewModal
    },

    props: {
        isUsersWhoLikedReviewModalActive: false,
        isUsersWhoDislikedReviewModalActive: false
    },

    methods: {
        close: function () {
            this.usersWhoLikedReviewModalActive = false;
            this.usersWhoDislikedReviewModalActive = false;
        }
    },

    computed: {
        usersWhoLikedReviewModalActive: {
            get: function () {
                return this.isUsersWhoLikedReviewModalActive
            },
            set: function (newValue) {
                this.$emit('updateUsersWhoLikedReviewModalActive',newValue);
            }
        },
        
        usersWhoDislikedReviewModalActive: {
            get: function () {
                return this.isUsersWhoDislikedReviewModalActive
            },
            set: function (newValue) {
                this.$emit('updateUsersWhoDislikedReviewModalActive',newValue);
            }
        },

        ...mapState('review', {
            usersWhoLikedReview: 'usersWhoLikedReview',
            usersWhoDislikedReview: 'usersWhoDislikedReview',
            isUsersModalLoading: 'isUsersModalLoading'
        })
    }
};
</script>
