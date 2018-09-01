<template>
    <div>
        <GeneralInfo />
        <div class="container user-cities">
            <h3 class="subtitle is-4">{{ userProfile.first_name }}'s lists</h3>
            <ul class="columns is-variable is-4 is-multiline user-cities-items">
                <ListsContainer
                    v-for="userList in filteredUserLists"
                    :key="userList.id"
                    :user-list="userList"
                />
            </ul>
        </div>
        <ReviewsContainer />
    </div>
</template>

<script>
import {mapState, mapActions, mapGetters} from 'vuex';
import GeneralInfo from '@/components/users/GeneralInfo';
import ListsContainer from '@/components/users/ListsContainer';
import ReviewsContainer from '@/components/users/ReviewsContainer';

export default {
    name: 'OtherUserPage',
    components: {
        GeneralInfo,
        ListsContainer,
        ReviewsContainer
    },
    computed: {
        ...mapGetters({
            userProfile: 'users/getUserProfile'
        }),
        ...mapState('userList', [
            'userLists',
            'places'
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
    }
};
</script>

<style scoped>

</style>