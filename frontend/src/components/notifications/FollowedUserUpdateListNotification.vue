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
        <div class="detailed-info" v-if="showDetailedInfo">
            <div class="attached-places" v-if="attachedPlaces.length > 0">
                <span class="place-announce">
                    {{ $t('notifications.followed_user_update_list.attached_places') }}
                </span>
                <span
                    v-for="(place, index) in attachedPlaces"
                    :key="index"
                    class="place-name"
                >
                    <router-link :to="`/places/${place.id}`">{{ getPlaceName(place) }}</router-link>
                </span>
            </div>
            <div class="detached-places" v-if="detachedPlaces.length > 0">
                <span class="place-announce">
                    {{ $t('notifications.followed_user_update_list.detached_places') }}
                </span>
                <span
                    v-for="(place, index) in detachedPlaces"
                    :key="index"
                    class="place-name"
                >
                    <router-link :to="`/places/${place.id}`">{{ getPlaceName(place) }}</router-link>
                </span>
            </div>
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
    methods: {
        getPlaceName(place) {
            return place.localization[0]['place_name'];
        }
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
        },
        attachedPlaces() {
            return this.notification['attached_places'];
        },
        detachedPlaces() {
            return this.notification['detached_places'];
        },
        showDetailedInfo() {
            return this.detailed
                && (this.attachedPlaces.length > 0 || this.detachedPlaces.length > 0)
        }
    }
};
</script>

<style lang="scss" scoped>
    @import '@/assets/scss/notifications.scss';

    .detailed-info {
        margin-top: 20px;

        .place-announce {
            margin-right: 5px;
            font-style: italic;
        }

        .place-name {
            margin-right: 4px;

            &:not(:last-child):after {
                content: ', ';
                margin-right: 0;
            }
        }
    }
</style>