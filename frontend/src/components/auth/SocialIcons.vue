<template>
    <div class="level is-moble social">
        <div class="level-left">
            <div class="level-item" @click="redirect('facebook')">
                <i class="fab fa-facebook-square" />
            </div>
        </div>
    </div>
</template>

<script>
import httpService from '@/services/common/httpService';

export default {
    name: 'SocialIcons',
    methods: {
        redirect(provider) {
            httpService.get(`/auth/social/${provider}/redirect`)
                .then((response) => {
                    window.location.replace(response.data.data.url);
                })
                .catch((error) => {
                    this.$toast.open(error.error);
                });
        }
    }
};
</script>

<style lang="scss" scoped>
    .social {
        font-size: 2rem;
        margin-top: 1rem;
        color: rgba(121, 87, 213, 0.8);
        cursor: pointer;
        &:hover {
            color: rgb(121, 87, 213);
        }
    }
</style>