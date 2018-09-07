<template>
    <div class="notification-message">
        <span class="user">
            <img class="user__avatar" :src="getUserAvatar">
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
export default {
    name: 'LikeReviewNotification',
    props: {
        notification: {
            required: true,
            type: Object
        },
        user: {
            required: true,
            type: Object
        },
        createdAt: {
            default: null,
            type: Object
        }
    },
    computed: {
        getUserName() {
            return this.user.info['first_name'];
        },
        getUserAvatar() {
            return this.user.info['avatar_url'];
        },
        getDate() {
            const date = new Date(this.createdAt['date']);
            const options = {
                year: 'numeric',
                month: 'numeric',
                day: 'numeric'
            };
            return date.toLocaleString('en-US', options);
        }
    }
};
</script>

<style scoped>
    .date {
        font-size: 12px;
    }
</style>