<template>
    <div class="media">
        <div class="media-left">
            <figure class="image is-64x64">
                <img :src="profilePhoto" :alt="fullName">
            </figure>
        </div>
        <div class="media-content">
            <router-link :to="`/user/${user.id}`" class="userName">
                {{fullName}}
            </router-link>
        </div>
    </div>
</template>

<script>
    import UserPlaceholder from '@/assets/user-placeholder.jpg'

    export default {
        name: "UserListItem",
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
    }
</script>

<style lang="scss" scoped>
    .userName{
        font-weight: bold;
    }
    .image{
        img{
            border-radius: 8px;
        }
    }
</style>