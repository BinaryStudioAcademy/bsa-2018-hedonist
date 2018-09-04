<template>
    <div class="container user-cities">
        <h3 class="subtitle is-4">{{ userProfile.first_name }}'s lists</h3>
        <ul class="columns is-variable is-4 is-multiline user-cities-items">
            <ListsContainerItem
                v-for="userList in filteredUserLists"
                :key="userList.id"
                :user-list="userList"
            />
        </ul>
    </div>
</template>

<script>
import {mapState, mapActions, mapGetters} from 'vuex';
import ListsContainerItem from '@/components/users/ListsContainerItem';
export default {
    name: 'ListsContainer',
    data() {
        return {};
    },
    components: {
        ListsContainerItem
    },
    computed: {
        ...mapGetters({
            userProfile: 'users/getUserProfile'
        }),
        ...mapState('userList', [
            'userLists'
        ]),
        filteredUserLists: function () {
            return this.userLists ? this.userLists.byId : null;
        }
    },
    created() {
        this.getUsersLists(this.$route.params.id);
    },
    methods: {
        ...mapActions({
            getUsersLists: 'userList/getListsByUser',
        }),
    },
};
</script>

<style lang="scss">
.user-cities{
    margin-top: 30px;
    h3{
        @media screen and (max-width: 768px) {
            text-align: center;
        }

    }
}
</style>