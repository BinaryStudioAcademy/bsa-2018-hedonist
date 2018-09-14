<template>
    <div class="columns">
        <template v-for="user in users">
            <div class="column user-wrapper is-one-quarter" :key="user.id">
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

        @media screen and (max-width: 411px) {
            flex: available;
            display: block;
        }

        .column {
            padding-top: 1rem;

            @media screen and (max-width: 769px) {
                flex: none;
                width: 33%;
            }

            @media screen and (max-width: 411px) {
                width: 100%;
            }
        }
    }

</style>