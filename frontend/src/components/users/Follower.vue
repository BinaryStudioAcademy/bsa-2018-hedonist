<template>
    <div class="wrapper">
        <figure class="image is-64x64">
            <img :src="profilePhoto" :alt="fullName">
        </figure>
        <router-link :to="`/users/${user.id}`" class="userName">
            {{ fullName }}
        </router-link>
    </div>
</template>

<script>
import UserPlaceholder from '@/assets/user-placeholder.png';

export default {
    name: 'Follower',
    props: {
        user: {
            type: Object,
            required: true
        }
    },
    computed: {
        profilePhoto() {
            return this.user.avatar_url || UserPlaceholder;
        },
        fullName() {
            return this.user.first_name + ' ' + this.user.last_name;
        }
    }
};
</script>

<style lang="scss" scoped>
    .userName {
        font-weight: bold;
        font-size: 1.3rem;
        align-self: center;
        margin-left: 10px;
    }

    .wrapper{
        display: flex;

        @media screen and (max-width: 768px) {
            justify-content: center;
        }
    }

    .image {
        img {
            border-radius: 8px;
        }
    }
</style>