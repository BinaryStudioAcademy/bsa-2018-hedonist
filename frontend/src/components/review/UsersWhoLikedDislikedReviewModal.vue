<template>
    <form @submit.prevent>
        <div class="modal-card" style="width: auto">
            <header class="modal-card-head">
                <p class="modal-card-title">{{ title }}</p>
            </header>
            <section class="modal-card-body">
                <div v-if="isUsersModalLoading">
                    <SmallPreloader :active="isUsersModalLoading" />
                </div>
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
                    <div class="has-text-primary user-name">{{ userFullname(user) }}</div>
                </div>
            </section>
            <footer class="modal-card-foot">
                <div>
                    <button class="button" type="button" @click="$emit('close')">Close</button>
                </div>
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
        title: {
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
        border-radius: 50%;
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
        width: 250px;
        height: 220px;
        display: flex;
        justify-content: center;
        align-items: center;
        flex-direction: column;
    }

    .modal-card-foot {
        display: flex;
        justify-content: flex-end;
    }
</style>
