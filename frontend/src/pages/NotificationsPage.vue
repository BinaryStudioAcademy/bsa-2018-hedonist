<template>
    <div class="container notifications notifications-page">
        <Preloader :active="isLoading" />
        <div class="notifications__delete" v-if="notifications.length > 0">
            <div class="button is-danger" @click="onDelete">
                {{ $t('notifications.clear-notifications') }}
            </div>
        </div>
        <ul class="notifications__list" v-if="notifications.length > 0">
            <li
                class="notifications__item"
                v-for="(notification, index) in notifications"
                :key="index"
            >
                <component
                    :is="notificationComponent(notification.data.notification.type)"
                    :notification="notification.data.notification.subject"
                    :user="getUser(notification.data.notification['subject_user'].id)"
                    :created-at="notification['created_at']"
                />
            </li>
        </ul>
        <div v-else class="notifications__none">
            {{ $t('notifications.no-notifications') }}
        </div>
    </div>
</template>

<script>
import { mapActions, mapGetters, mapMutations } from 'vuex';

import LikeReviewNotification             from '@/components/notifications/LikeReviewNotification';
import DislikeReviewNotification          from '@/components/notifications/DislikeReviewNotification';
import FollowedUserReviewNotification     from '@/components/notifications/FollowedUserReviewNotification';
import FollowedUserAddPlaceNotification   from '@/components/notifications/FollowedUserAddPlaceNotification';
import FollowedUserAddListNotification    from '@/components/notifications/FollowedUserAddListNotification';
import FollowedUserDeleteListNotification from '@/components/notifications/FollowedUserDeleteListNotification';
import FollowedUserUpdateListNotification from '@/components/notifications/FollowedUserUpdateListNotification';
import ReviewPlaceNotification            from '@/components/notifications/ReviewPlaceNotification';
import UserFollowNotification             from '@/components/notifications/UserFollowNotification';
import UserUnfollowNotification           from '@/components/notifications/UserUnfollowNotification';
import UnknownNotification                from '@/components/notifications/UnknownNotification';
import {
    LIKE_REVIEW_NOTIFICATION,
    REVIEW_PLACE_NOTIFICATION,
    FOLLOWED_USER_REVIEW_NOTIFICATION,
    FOLLOWED_USER_ADD_PLACE_NOTIFICATION,
    DISLIKE_REVIEW_NOTIFICATION,
    USER_FOLLOW_NOTIFICATION,
    USER_UNFOLLOW_NOTIFICATION,
    FOLLOWED_USER_ADD_LIST_NOTIFICATION,
    FOLLOWED_USER_DELETE_LIST_NOTIFICATION,
    FOLLOWED_USER_UPDATE_LIST_NOTIFICATION
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
        FollowedUserAddPlaceNotification,
        DislikeReviewNotification,
        UserFollowNotification,
        UserUnfollowNotification,
        FollowedUserAddListNotification,
        FollowedUserDeleteListNotification,
        FollowedUserUpdateListNotification
    },
    created() {
        if (this.notifications.length < 1) {
            this.setLoading(true);
        }

        this.readNotifications();
        this.getNotifications().then(() => {
            this.setLoading(false);
        });
    },
    computed: {
        ...mapGetters({
            isUserLoggedIn: 'auth/isLoggedIn',
            user: 'auth/getAuthenticatedUser',
            getUser: 'users/getUserProfile',
            isLoading: 'loading',
            notifications: 'notifications/getNotifications'
        }),
    },
    methods: {
        ...mapActions({
            getNotifications: 'notifications/getNotifications',
            readNotifications: 'notifications/readNotifications',
            deleteNotifications: 'notifications/deleteNotifications'
        }),
        ...mapMutations({ setLoading: 'SET_LOADING' }),
        notificationComponent: function(type) {
            switch (type) {
            case LIKE_REVIEW_NOTIFICATION:
                return 'LikeReviewNotification';
            case REVIEW_PLACE_NOTIFICATION:
                return 'ReviewPlaceNotification';
            case FOLLOWED_USER_REVIEW_NOTIFICATION:
                return 'FollowedUserReviewNotification';
            case FOLLOWED_USER_ADD_PLACE_NOTIFICATION:
                return 'FollowedUserAddPlaceNotification';
            case DISLIKE_REVIEW_NOTIFICATION:
                return 'DislikeReviewNotification';
            case USER_FOLLOW_NOTIFICATION:
                return 'UserFollowNotification';
            case USER_UNFOLLOW_NOTIFICATION:
                return 'UserUnfollowNotification';
            case FOLLOWED_USER_ADD_LIST_NOTIFICATION:
                return 'FollowedUserAddListNotification';
            case FOLLOWED_USER_DELETE_LIST_NOTIFICATION:
                return 'FollowedUserDeleteListNotification';
            case FOLLOWED_USER_UPDATE_LIST_NOTIFICATION:
                return 'FollowedUserUpdateListNotification';
            default:
                return 'UnknownNotification';
            }
        },
        onDelete() {
            if (confirm(this.$t('notifications.confirm-deleting'))) {
                this.setLoading(true);
                this.deleteNotifications().then(() => {
                    this.setLoading(false);
                    this.notifications = [];
                });
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
                width: 50px !important;
                height: 50px !important;
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
    $dark-red: #ce143a;

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
        
        &__delete {
            text-align: right;

            .button:hover {
                background-color: $dark-red;
            }
        }

        &__none {
            text-align: center;
            font-weight: bold;
        }
    }
</style>