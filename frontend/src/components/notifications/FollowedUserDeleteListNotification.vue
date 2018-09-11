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
        <span class="text">{{ $t('notifications.followed_user_delete_list.delete') }}</span>
        <span>{{ this.notification }}</span>
        <span class="date" v-if="createdAt">
            ({{ getDate }})
        </span>
    </div>
</template>

<script>
import avatarStub from '@/assets/user-placeholder.png';

export default {
    name: 'FollowedUserDeleteListNotification',
    props: {
        notification: {
            required: true,
            type: String
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
    data() {
        return {
            avatarStub: avatarStub
        };
    },
    computed: {
        getUserName() {
            return this.user.info['first_name'];
        },
        getUserAvatar() {
            return this.user.info['avatar_url']
                ? this.user.info['avatar_url']
                : this.avatarStub;
        },
        getDate() {
            const date = new Date(this.createdAt['date']);
            const options = {
                year: 'numeric',
                month: 'numeric',
                day: 'numeric',
                hour: 'numeric',
                minute: 'numeric',
                second: 'numeric'
            };
            return date.toLocaleString('en-US', options);
        }
    }
};
</script>

<style lang="scss" scoped>
    @import '@/assets/scss/notifications.scss';
</style>