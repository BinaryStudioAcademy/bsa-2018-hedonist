<template>
    <section class="container">
        <div class="columns is-multiline centered">
            <UserListsItem
                v-for="(userList, index) in userLists"
                :user-list="userList"
                :key="index"
                :timer="300 * (index+1)"
            />
        </div>
    </section>
</template>

<script>
import UserListsItem from './UserListsItem';

export default {
    name: 'UserListsList',
    data() {
        return {
            userLists: [],
        };
    },
    created() {
        this.$store.dispatch('userlists/getUserLists', this.user.id)
            .then((result) => {
                this.userLists = result;
            });
    },
    computed: {
        user() {
            return this.$store.getters['auth/getAuthenticatedUser'];
        }
    },
    components: {UserListsItem},
};
</script>

<style lang="scss" scoped>
    section {
        background: #FFF;
        min-height: calc(100vh - 42px);
    }

    li {
        padding-left: 1rem;
        display: flex;
    }

    ul {
        list-style: none;
    }

    .index {
        width: 10%;
        text-align: center;
        color: grey;
    }

    @media (max-width: 1223px) {
        .columns {
            padding-top: 2.5rem;
            padding-left: 1.5rem;
            padding-right: 1.5rem;
        }
    }

    @media (min-width: 1224px) {
        .columns {
            padding-top: 2.5rem;
            padding-left: calc((100% - 300px * 3) / 2);
            padding-right: calc((100% - 300px * 3) / 2);
        }
    }

    @media (min-width: 520px) and (max-width: 845px) {

        .columns.is-multiline {
            -ms-flex-wrap: wrap;
            flex-wrap: wrap;
            display: flex;
            height: 100vh;
        }
    }

</style>
