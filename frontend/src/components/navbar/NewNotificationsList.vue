<template>
    <div class="notifications">
        <span
            :class="[
                'navbar-notification-btn',
                'notification-icon',
                notificationIconActiveClass
            ]"
            @click="$emit('toggleNotifications')"
            v-click-outside="onHideNotifications"
        />
        <div v-if="notificationsDisplay" class="notifications__wrapper">
            <ul class="notifications__list" v-if="notifications.length > 0">
                <li
                    class="notifications__item"
                    v-for="(notification, index) in notifications"
                    :key="index"
                >
                    <component
                        :is="notificationComponent(getNotificationType(notification))"
                        :notification="getNotificationSubject(notification)"
                        :user="getNotificationUser(notification)"
                    />
                </li>
            </ul>
            <div v-else class="notifications__none">
                {{ $t('notifications.navbar.no_notifs') }}
            </div>
        </div>
    </div>
</template>

<script>
import { mapGetters } from 'vuex';
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

export default {
    name: 'NewNotificationsList',
    props: {
        isNewNotifications: {
            required: true,
            type: Boolean
        },
        notificationsDisplay: {
            required: true,
            type: Boolean
        }
    },
    components: {
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
    computed: {
        ...mapGetters({
            notifications: 'notifications/getUnreadNotifications',
        }),
        notificationIconActiveClass() {
            return this.isNewNotifications
                ? 'notification-icon--active'
                : null;
        },
    },
    methods: {
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
        getNotificationUser(notification) {
            return notification.data.notification['subject_user'];
        },
        getNotificationSubject(notification) {
            return notification.data.notification.subject;
        },
        getNotificationType(notification) {
            return notification.data.notification.type;
        },
        onHideNotifications() {
            this.$emit('hideNotifications');
        }
    }
};
</script>

<style lang="scss" scoped>
    $blue: #167df0;
    $grey: #c5c5c5;
    $dark-grey: #4a4a4a;

    .notification-icon {
        position: relative;

        &--active:after {
            content: "";
            display: block;
            position: absolute;
            bottom: 0;
            right: 0;
            background-color: red;
            border-radius: 50%;
            width: 10px;
            height: 10px;
        }
    }

    .notifications {
        position: relative;

        &__wrapper {
            position: absolute;
            color: $dark-grey;
            top: 42px;
            right: 0;
            border-radius: 5px;
            background-color: #fff;
            width: 300px;
            max-height: 150px;
            overflow-x: hidden;
            overflow-y: auto;
            box-shadow: 0px 3px 20px $blue;
        }

        &__item {
            border-bottom: $grey 1px solid;
            padding: 10px;
            word-break: break-word;

            &:hover {
                background-color: darken(#fff, 10%);
            }

            &:last-child {
                border-bottom: none;
            }
        }

        &__none {
            text-align: center;
            padding: 10px;
        }
    }

    .navbar-notification-btn {
        cursor: pointer;
        background: url("../../assets/icon-notifications.png") top left no-repeat;
        font-weight: bold;
        height: 24px;
        width: 27px;
        align-self: center;
    }
</style>