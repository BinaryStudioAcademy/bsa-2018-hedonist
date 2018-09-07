<template>
    <div class="container notifications-page">
        <ul class="notifications__list" v-if="notifications.length > 0">
            <li
                class="notifications__item"
                v-for="(notification, index) in notifications"
                :key="index"
            >
                <component
                    :is="notificationComponent(notification)"
                    :notification="notification.subject"
                    :user="getUser(notification['subject_user'].id)"
                />
            </li>
        </ul>
    </div>
</template>

<script>
import { mapActions, mapGetters, mapMutations } from 'vuex';
import LikeReviewNotification from '@/components/notifications/LikeReviewNotification';
import FollowedUserReviewNotification from '@/components/notifications/FollowedUserReviewNotification';
import FollowedUserAddPlaceNotification from '@/components/notifications/FollowedUserAddPlaceNotification';
import ReviewPlaceNotification from '@/components/notifications/ReviewPlaceNotification';
import UnknownNotification from '@/components/notifications/UnknownNotification';
import {
    LIKE_REVIEW_NOTIFICATION,
    REVIEW_PLACE_NOTIFICATION,
    FOLLOWED_USER_REVIEW_NOTIFICATION,
    FOLLOWED_USER_ADD_PLACE_NOTIFICATION
} from '@/services/notification/notificationService';

export default {
    name: "NotificationsPage",
    components: {
        LikeReviewNotification,
        UnknownNotification,
        ReviewPlaceNotification,
        FollowedUserReviewNotification,
        FollowedUserAddPlaceNotification
    },
    data() {
        return {
            notifications: []
        }
    },
    created() {
        this.getNotifications().then((notifications) => {
            console.log(notifications);

            _.forEach(notifications, ({ data }) => {
                this.addUser(data.notification['subject_user']);
                this.notifications.push(data.notification);
            });
        });
    },
    computed: {
        ...mapGetters({
            isUserLoggedIn: 'auth/isLoggedIn',
            user: 'auth/getAuthenticatedUser',
            getUser: 'users/getUserProfile'
        }),
    },
    methods: {
        ...mapActions({
            getNotifications: 'notifications/getNotifications',
            readNotifications: 'notifications/readNotifications',
        }),
        ...mapMutations('users', {
            addUser: 'ADD_USER',
        }),
        notificationComponent: function(notification) {
            switch (notification.type) {
                case LIKE_REVIEW_NOTIFICATION:
                    return 'LikeReviewNotification';
                case REVIEW_PLACE_NOTIFICATION:
                    return 'ReviewPlaceNotification';
                case FOLLOWED_USER_REVIEW_NOTIFICATION:
                    return 'FollowedUserReviewNotification';
                case FOLLOWED_USER_ADD_PLACE_NOTIFICATION:
                    return 'FollowedUserAddPlaceNotification';
                default:
                    return 'UnknownNotification';
            }
        }
    }
}
</script>

<style lang="scss">
    .notifications-page {
        background-color: #fff;
        min-height: calc(100vh - 52px);
        padding: 50px 20px 10px;
        .user__avatar {
            width: 50px;
            height: 50px;
        }
    }
</style>