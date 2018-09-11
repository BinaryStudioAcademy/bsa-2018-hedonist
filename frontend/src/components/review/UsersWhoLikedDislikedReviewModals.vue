<template>
    <section>
        <b-modal
            :v-if="!isUsersModalLoading"
            :active.sync="usersWhoLikedReviewModalActive"
            has-modal-card
        >
            <UsersWhoLikedDislikedReviewModal
                :users="usersWhoLikedReview"
                :title="$t('place_page.review.modal.like')"
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
                :title="$t('place_page.review.modal.dislike')"
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
        isUsersWhoLikedReviewModalActive: {
            required: true,
            type: Boolean
        },

        isUsersWhoDislikedReviewModalActive: {
            required: true,
            type: Boolean
        }
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
                return this.isUsersWhoLikedReviewModalActive;
            },
            set: function (newValue) {
                this.$emit('updateUsersWhoLikedReviewModalActive',newValue);
            }
        },
        
        usersWhoDislikedReviewModalActive: {
            get: function () {
                return this.isUsersWhoDislikedReviewModalActive;
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
