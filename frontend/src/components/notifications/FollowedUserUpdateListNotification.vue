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
import notificationsMixin from '@/components/mixins/notifications';

export default {
    name: 'FollowedUserUpdateListNotification',
    mixins: [notificationsMixin],
    props: {
        detailed: {
            default: false,
            type: Boolean
        }
    },
    methods: {
        getPlaceName(place) {
            return place.localization[0]['place_name'];
        }
    },
    computed: {
        attachedPlaces() {
            return this.notification['attached_places'];
        },
        detachedPlaces() {
            return this.notification['detached_places'];
        },
        showDetailedInfo() {
            return this.detailed
                && (this.attachedPlaces.length > 0 || this.detachedPlaces.length > 0);
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