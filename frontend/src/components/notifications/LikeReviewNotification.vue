<template>
    <div class="notification-message">
        <span class="user">
            <span class="user__avatar-wrp">
                <img class="user__avatar" :src="getUserAvatar">
            </span>
            <router-link
                class="user__name"
                :to="{ name: 'OtherUserPage', params: { id: user.id } }"
            >
                {{ getUserName }}
            </router-link>
        </span>
        <span class="text">{{ $t('notifications.like_review.liked') }}</span>
        <span class="review-link">
            <router-link :to="`/places/${notification['place_id']}`">
                {{ $t('notifications.like_review.review') }}
            </router-link>
        </span>
        <span class="date" v-if="createdAt">
            ({{ getDate }})
        </span>
    </div>
</template>

<script>
import notificationsMixin from '@/components/mixins/notifications';

export default {
    name: 'LikeReviewNotification',
    mixins: [notificationsMixin]
};
</script>

<style lang="scss" scoped>
    @import '@/assets/scss/notifications.scss';
</style>