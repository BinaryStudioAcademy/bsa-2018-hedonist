<template>
    <section class="container">
        <b-loading :active.sync="isLoading" />
        <ul v-show="isLoaded">
            <ListPreview
                v-for="(userList,index,key) in filteredUserListsNormalized"
                :key="userList.id"
                :user-list="userList"
                :timer="50 * (key+1)"
            />
        </ul>
    </section>
</template>

<script>
import ListPreview from './ListPreview';
import { mapState, mapGetters } from 'vuex';
export default {
    name: 'ListPreviewItems',
    components: {
        ListPreview
    },
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
            'userLists',
            'userListsNormalized',
            'placesNormalized'
        ]),
        ...mapGetters('auth', {
            Auth: 'getAuthenticatedUser'
        }),
        ...mapGetters('userList', {
            getFilteredNormalizedByCity: 'getFilteredNormalizedByCity',
        }),
        isLoaded: function () {
            return !!(this.userListsNormalized);
        },
        filteredUserListsNormalized: function () {
            let filtered = this.userListsNormalized ? this.userListsNormalized.byId : null;
            let cityId = this.filterBy.cityId;
            if (cityId) {
                filtered = this.getFilteredNormalizedByCity(filtered, cityId);
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