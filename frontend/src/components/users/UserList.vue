<template>
    <div class="columns">
        <template v-for="user in users">
            <div class="column is-one-quarter" :key="user.id">
                <UserListItem
                    :user="user"
                />
            </div>
        </template>
    </div>
</template>

<script>
import UserListItem from './UserListItem';

export default {
    name: 'UserList',
    props: {
        users: {
            type: Array,
            required: true,
        }
    },
    components: {UserListItem},
};
</script>

<style lang="scss" scoped>

</style>