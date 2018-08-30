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
                    <div class="image is-64x64 user-avatar">
                        <img 
                            v-if="user.avatar_url"
                            :src="user.avatar_url"
                            :alt="userFullname(user)"
                        >
                        <img
                            v-else
                            src="/assets/add_review_default_avatar.png"
                            :alt="userFullname(user)"
                        >
                    </div>
                    <div class="has-text-primary user-name">
                        <a :href="userPage(user.id)">
                            {{ userFullname(user) }}
                        </a>
                    </div>
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
    .user-item {
        display: flex;
        align-content: space-between;
        justify-content: space-between;
        min-height: 70px;
        width: 100%;
    }

    .user-avatar {
        padding: 10px;
    }

    .user-avatar img {
        border-radius: 50%;
        float: left;
    }

    .user-name {
        padding: 10px;
        font-size: 0.9em;
        width: 80%;
    }

    .modal-card-title {
        text-align: center;
    }
    
    .modal-card-body {
        width: 100%;
        min-width: 260px;
        height: 220px;
        display: flex;
        flex-direction: column;
    }

    .modal-card-body::before, .modal-card-body::after {
        content: '';  
        margin: auto; 
    }

    .modal-card-foot {
        display: flex;
        justify-content: flex-end;
    }
</style>
