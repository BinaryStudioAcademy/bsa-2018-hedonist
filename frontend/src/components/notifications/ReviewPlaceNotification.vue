<template>
    <div class="notification-message">
        <div class="user-info">
            <div class="user-info__avatar"><img :src="getUserAvatar"></div>
            <div class="user-name">{{ getUserName }}</div>
        </div>
        <div class="text">made review on your place</div>
    </div>
</template>

<script>
export default {
    name: "LikeReviewNotification",
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
}
</script>

<style scoped>

</style>