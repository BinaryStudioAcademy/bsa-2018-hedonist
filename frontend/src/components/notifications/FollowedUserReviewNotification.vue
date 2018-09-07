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
        <span class="text">made a review on</span>
        <span class="place-link">
            <router-link :to="`/places/${notification['id']}`">
                {{ getPlaceName }}
            </router-link>
        </span>
    </div>
</template>

<script>
export default {
    name: 'FollowedUserReviewNotification',
    props: {
        notification: {
            required: true,
            type: Object
        },
        user: {
            required: true,
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
        getPlaceName() {
            return this.notification.localization[0]['place_name'];
        }
    }
};
</script>

<style scoped>

</style>