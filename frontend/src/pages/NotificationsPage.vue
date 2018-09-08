<template>
    <div class="container notifications notifications-page">
        <Preloader :active="!isLoading" />
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
                    :created-at="notification['created_at']"
                />
            </li>
        </ul>
    </div>
</template>

<script>
import { mapActions, mapGetters, mapMutations, mapState } from 'vuex';
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
import Preloader from '@/components/misc/Preloader';

export default {
    name: 'NotificationsPage',
    components: {
        Preloader,
        LikeReviewNotification,
        UnknownNotification,
        ReviewPlaceNotification,
        FollowedUserReviewNotification,
        FollowedUserAddPlaceNotification
    },
    data() {
        return {
            notifications: []
        };
    },
    created() {
        if (this.notifications.length > 0) {
            this.setLoading(true);
        }

        this.readNotifications();
        this.getNotifications().then((notifications) => {
            _.forEach(notifications, ({ data, created_at, read_at }) => {
                this.addUser(data.notification['subject_user']);
                this.notifications.push({
                    ...data.notification,
                    created_at
                })  ;
            });
            this.setLoading(true);
        });
    },
    computed: {
        ...mapGetters({
            isUserLoggedIn: 'auth/isLoggedIn',
            user: 'auth/getAuthenticatedUser',
            getUser: 'users/getUserProfile',
            isLoading: 'loading'
        })
    },
    methods: {
        ...mapActions({
            getNotifications: 'notifications/getNotifications',
            readNotifications: 'notifications/readNotifications',
        }),
        ...mapMutations('users', {
            addUser: 'ADD_USER',
        }),
        ...mapMutations({ setLoading: 'SET_LOADING' }),
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
};
</script>

<style lang="scss">
    .notifications-page {
        background-color: #fff;
        min-height: calc(100vh - 52px);
        padding: 50px;

        .user {
            &__avatar-wrp {
                display: inline-block;
                width: 50px !important;
                height: 50px !important;
            }

            &__avatar {
                border-radius:4px;
                width: 100%;
                height: 100%;
                object-fit: cover;
                object-position: 50% 50%;
            }
        }

        .date {
            font-size: 12px;
        }
    }
</style>

<style lang="scss" scoped>
    $grey: #c5c5c5;
    $dark-grey: #4a4a4a;

    .notifications {
        color: $dark-grey;

        &__item {
            border-bottom: $grey 1px solid;
            margin: 15px 0;
            padding-bottom: 10px;

            &:last-child {
                border-bottom: none;
            }
        }
    }
</style>