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
    .columns {
        display: flex;
        flex-flow: row wrap;
        align-content: space-between;

        @media screen and (max-width: 400px) {
            display: block;
        }

        .column {
            padding-top: 1rem;
        }
    }

</style>