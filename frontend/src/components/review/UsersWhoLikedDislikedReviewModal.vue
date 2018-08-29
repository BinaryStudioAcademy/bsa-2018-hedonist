<template>
    <form @submit.prevent>
        <div class="modal-card" style="width: auto">
            <header class="modal-card-head">
                <p class="modal-card-title">Users who {{ action }} review</p>
            </header>
            <section class="modal-card-body">
                <SmallPreloader
                    v-if="isUsersModalLoading"
                    :active="isUsersModalLoading"
                />
                <div
                    v-else
                    v-for="(user, index) in users"
                    :key="index + 1"
                    class="user-item"
                >
                    <div class="image is-64x64">
                        <a :href="userPage(user.id)">
                            <img 
                                v-if="user.avatar_url"
                                class="user-avatar"
                                :src="user.avatar_url"
                                :alt="userFullname(user)"
                            >
                            <img
                                v-else
                                class="user-avatar"
                                src="/assets/add_review_default_avatar.png"
                                :alt="userFullname(user)"
                            >
                        </a>
                    </div>
                    <div class="user-name">{{ userFullname(user) }}</div>
                </div>
            </section>
            <footer class="modal-card-foot">
                <button class="button" type="button" @click="$emit('close')">Close</button>
            </footer>
        </div>
    </form>    
</template>

<script>
import { mapState } from 'vuex';
import SmallPreloader from '@/components/misc/SmallPreloader';

export default {
    name: 'UsersWhoLikedDislikedReviewModal',

    components: {
        SmallPreloader
    },

    computed: {
        ...mapState('review', {
            isUsersModalLoading: 'isUsersModalLoading',
        })
    },

    props: {
        users: {
            type: Array,
            required: true
        },
        action: {
            type: String,
            required: true
        }
    },

    methods: {
        userPage: function (userId) {
            return `/users/${userId}`;
        },

        userFullname: function(user) {
            return `${user.first_name} ${user.last_name}`;
        }
    }
};
</script>

<style lang="scss" scoped>
    .user-avatar {
        border-radius: 5px;
        padding: 10px;
        float: left;
    }

    .user-item {
        display: flex;
        justify-content: center;
    }

    .user-name {
        padding: 10px;
    }

    .modal-card-title {
        text-align: center;
    }
    
    .modal-card-body {
        width: 100%;
        height: 210px;
    }
</style>
