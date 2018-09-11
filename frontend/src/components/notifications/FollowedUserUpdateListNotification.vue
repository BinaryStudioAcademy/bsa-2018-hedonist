<template>
    <div class="notification-message">
        <div class="general-info">
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
                <span class="text">{{ $t('notifications.followed_user_update_list.update') }}</span>
                <span class="list-link">
                <router-link :to="`/list/${notification['id']}`">
                    {{ this.notification.name }}
                </router-link>
            </span>
                <span class="date" v-if="createdAt">
                ({{ getDate }})
            </span>
        </div>
        <div class="detailed-info">

        </div>
    </div>
</template>

<script>
import avatarStub from '@/assets/user-placeholder.png';

export default {
    name: 'FollowedUserUpdateListNotification',
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
        },
        detailed: {
            default: false,
            type: Boolean
        }
    },
    data() {
        return {
            avatarStub: avatarStub
        };
    },
    created() {
        console.log(this.notification);
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
    span {
        display: inline-block;
        vertical-align: middle;
    }

    .user {
        padding-top: 2px;

        &__avatar-wrp {
            width: 30px;
            height: 30px;
        }

        &__avatar {
            border-radius:4px;
            width: 100%;
            height: 100%;
            object-fit: cover;
            object-position: 50% 50%;
        }
    }
</style>