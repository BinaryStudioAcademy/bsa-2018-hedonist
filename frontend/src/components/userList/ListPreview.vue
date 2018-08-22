<template>
    <section class="container">
        <b-loading :active.sync="isLoading" />
        <ul v-show="isLoaded">
            <li
                v-for="(userList,index) in filteredUserLists"
                :key="userList.id"
            >
                <ListPreviewItems
                    :user-list="userList"
                    :timer="50 * (index+1)"
                />
            </li>
        </ul>
    </section>
</template>

<script>
import ListPreviewItems from './ListPreviewItems';
import { mapState, mapGetters } from 'vuex';
export default {
    name: 'ListPreview',
    components: {ListPreviewItems},
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
            .dispatch('userList/getListsByUser', this.Auth.id)
            .then(()=>{
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
        ...mapGetters('auth', {
            Auth: 'getAuthenticatedUser'
        }),
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