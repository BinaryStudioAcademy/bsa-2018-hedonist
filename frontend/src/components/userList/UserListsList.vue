<template>
    <section class="container">
        <b-loading :active.sync="isLoading" />
        <ul v-show="isLoaded">
            <li
                v-for="(userList,index) in filteredUserLists"
                :key="userList.id"
            >
                <UserListsItem
                    :user-list="userList"
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
    data() {
        return {
            isLoading: true,
            filterBy: {
                cityId: null,
            },
        };
    },
    created() {
        this.$store
            .dispatch('userList/getListsByUser')
            .then(()=>{
                console.log(this.userLists[1].places);
                this.isLoading = false;
            })
            .catch(()=> {
                this.isLoading = false;
            });
    },
    computed: {
        ...mapState('userList', [
            'userLists'
        ]),
        isLoaded: function () {
            return !!(this.userLists);
        },
        filteredUserLists: function () {
            let filtered = this.userLists;

            if (this.filterBy.cityId) {
                filtered = filtered.filter(
                    ul => ul.places.filter(
                        pl => pl.city_id == this.filterBy.cityId
                    ).length > 0);
            }

            return filtered;
        }
    },
    methods: {
        setCityFilter(cityId){
            this.filterBy.cityId = cityId;
        }
    },
};
</script>

<style lang="scss" scoped>
    section {
        background: #FFF;
        padding: 0 10%;
        min-height: calc(100vh - 59px);
        overflow-y: scroll;

        ul {
            list-style: none;

            li {
                display: flex;
                margin-bottom: -5%;

                &:last-child {
                    margin-bottom: 0;
                }
            }
        }
    }
</style>
