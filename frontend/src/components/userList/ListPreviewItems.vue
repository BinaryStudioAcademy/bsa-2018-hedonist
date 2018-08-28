<template>
    <section class="container">
        <b-loading :active.sync="isLoading" />
        <div class="has-text-right">
            <router-link
                role="button"
                class="button is-success"
                to="/my-lists/add"
            >+ Add a new list</router-link>
        </div>
        <ul v-show="isLoaded">
            <ListPreview
                v-for="(userList,index,key) in filteredUserLists"
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
            'places'
        ]),
        ...mapGetters('auth', {
            Auth: 'getAuthenticatedUser'
        }),
        ...mapGetters('userList', {
            getFilteredByCity: 'getFilteredByCity',
        }),
        isLoaded: function () {
            return !!(this.userLists);
        },
        filteredUserLists: function () {
            let filtered = this.userLists ? this.userLists.byId : null;
            let cityId = this.filterBy.cityId;
            if (cityId) {
                filtered = this.getFilteredByCity(filtered, cityId);
            }
            return filtered;
        }
    },
    methods: {
        setCityFilter(cityId) {
            this.filterBy.cityId = cityId;
        }
    },
};
</script>

<style lang="scss" scoped>
    section {
        background: #FFF;
        padding: 50px 10%;
        min-height: calc(100vh - 59px);
    }
</style>