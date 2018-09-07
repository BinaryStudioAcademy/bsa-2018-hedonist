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
        <span class="text">liked your</span>
        <span class="review-link">
            <router-link :to="`/places/${notification['place_id']}`">
                review
            </router-link>
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
        }
    },
    computed: {
        getUserName() {
            return this.user.info['first_name'];
        },
        getUserAvatar() {
            return this.user.info['avatar_url'];
        }
    }
};
</script>

<style scoped>

</style>