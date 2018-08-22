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
import {mapActions} from 'vuex';

export default {
    name: 'SocialIcons',
    methods: {
        ...mapActions('auth',['socialRedirect']),
        redirect(provider){
            this.socialRedirect(provider)
                .then((redirectUri) => {window.location.replace(redirectUri);})
                .catch((error) => {this.$toast.open(error);});
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