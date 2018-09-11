<template>
    <div class="container user-cities">
        <h3 class="subtitle is-4">
            <template v-if="$i18n.locale() === 'en'">
                {{ userName }}'s {{ $t('other_user_page.lists_container.title') }}
            </template>
            <template v-else>
                {{ $t('other_user_page.lists_container.title') }} {{ userName }}
            </template>
        </h3>
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
        ...mapGetters('users',['getUserProfile']),
        ...mapState('userList', [
            'userLists'
        ]),
        filteredUserLists: function () {
            return this.userLists ? this.userLists.byId : null;
        },
        userProfile(){
            return this.getUserProfile(this.$route.params.id) || {};
        },
        userName(){
            return this.userProfile.first_name || '';
        }
    }
};
</script>

<style lang="scss">
.user-cities{
    margin: 30px 20px 10px;
    h3{
        @media screen and (max-width: 768px) {
            text-align: center;
        }

    }
}
</style>