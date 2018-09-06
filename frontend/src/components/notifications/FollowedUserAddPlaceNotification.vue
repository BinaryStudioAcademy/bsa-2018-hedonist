<template>
    <div class="notification-message">
        <span class="user">
            <img class="user__avatar" :src="getUserAvatar">
            <span class="user__name">
                <a href="#">{{ getUserName }}</a>
            </span>
        </span>
        <span class="text">added a new</span>
        <span class="place-link">
            <router-link :to="`/places/${notification['id']}`">
                place
            </router-link>
        </span>
    </div>
</template>

<script>
export default {
    name: 'FollowedUserAddPlaceNotification',
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