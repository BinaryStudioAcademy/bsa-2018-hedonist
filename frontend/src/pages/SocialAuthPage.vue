<template>
    <b-loading :active.sync="isLoading" />
</template>

<script>
import {mapActions} from 'vuex';

export default {
    name: 'SocialAuthPage',
    data() {
        return {
            isLoading: true
        };
    },
    methods: {
        ...mapActions('auth', ['socialLogin'])
    },
    created() {
        const data = this.$route.query;
        data.provider = this.$route.params.provider;
        this.socialLogin(data)
            .then(() => {this.$router.push({name:'home'});})
            .catch(() => {this.$router.push({name:'LoginPage'});});
    },
};
</script>

<style scoped>

</style>