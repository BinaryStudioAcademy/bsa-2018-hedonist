<template>
    <div class="columns">
        <template v-for="user in users">
            <div class="column is-one-quarter" :key="user.id">
                <Follower
                    :user="user"
                />
            </div>
        </template>
    </div>
</template>

<script>
import Follower from './Follower';

export default {
    name: 'FollowersList',
    props: {
        users: {
            type: Array,
            required: true,
        }
    },
    components: {Follower},
};
</script>

<style lang="scss" scoped>

</style>