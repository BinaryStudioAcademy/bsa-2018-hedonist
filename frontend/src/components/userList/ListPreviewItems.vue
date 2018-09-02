<template>
    <section class="container">
        <Preloader :active="isLoading" />
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
                @loading="loading"
            />
        </ul>
        <div class="no-lists-text" v-if="filteredUserLists.length < 1">
            {{ $t('my-lists_page.no-lists') }}
        </div>
    </section>
</template>

<script>
import ListPreview from './ListPreview';
import { mapState, mapGetters, mapActions } from 'vuex';
import Preloader from '@/components/misc/Preloader';

export default {
    name: 'ListPreviewItems',
    components: {
        ListPreview,
        Preloader
    },
    data() {
        return {
            isLoading: false,
            filterBy: {
                cityId: null,
            },
        };
    },
    created() {
        if (this.getUserLists.length < 1) {
            this.isLoading = true;
        }

        this.getListsByUser(this.Auth.id)
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
        ...mapGetters('userList', [
            'getFilteredByCity',
            'getUserLists'
        ]),
        isLoaded: function () {
            return !!(this.userLists);
        },
        filteredUserLists: function () {
            let filtered = this.userLists ? this.userLists.byId : null;
            let cityId = this.filterBy.cityId;
            if (cityId) {
                filtered = this.getFilteredByCity(filtered, cityId);
            }

            return this.sortByDesc(filtered);
        }
    },
    methods: {
        ...mapActions('userList', ['getListsByUser']),
        setCityFilter(cityId) {
            this.filterBy.cityId = cityId;
        },
        sortByDesc(lists) {
            let listArray = [];
            for (const listId in lists) {
                if (lists.hasOwnProperty(listId)) {
                    listArray.push(lists[listId]);
                }
            }

            return listArray.reverse();
        },
        loading(value) {
            this.isLoading = value;
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

    .no-lists-text {
        text-align: center;
        font-size: 20px;
        font-weight: bold;
        margin-top: 50px;
    }
</style>