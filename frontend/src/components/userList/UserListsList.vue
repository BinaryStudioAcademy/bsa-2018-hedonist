<template>
    <section class="container">
        <ul v-show="isLoaded">
            <li
                    v-for="(userList,index) in userLists"
                    :key="userList.id"
            >
                <UserListsItem
                        :userList="userList"
                        :timer="50 * (index+1)"
                />
            </li>
        </ul>
    </section>
</template>

<script>
    import UserListsItem from './UserListsItem';
    import { mapState, mapGetters } from 'vuex';

    export default {
        name: 'PlaceList',
        components: {UserListsItem},
        created() {
            this.$store.dispatch('userList/getListsByUser');
        },
        computed: {
            ...mapState('userList', [
                'userLists'
            ]),
            isLoaded: function () {
                return !!(this.userLists);
            }
        },
    };
</script>

<style lang="scss" scoped>
    section {
        background: #FFF;
        padding: 0 10%;

        ul {
            list-style: none;

            li {
                display: flex;
                margin-bottom: 5%;

                &:last-child {
                    margin-bottom: 0;
                }
            }
        }
    }
</style>
