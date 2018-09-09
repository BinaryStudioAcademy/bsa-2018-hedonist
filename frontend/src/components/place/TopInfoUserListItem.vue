<template>
    <b-dropdown>
        <button class="button is-success" slot="trigger">
            <i class="far fa-save" />{{ $t('place_page.buttons.save') }}
            <b-icon icon="menu-down" />
        </button>
        <template>
            <b-dropdown-item v-if="!favouriteExist" @click="addToFavouriteList">
                {{ $t('place_page.top_info.favourite') }}
            </b-dropdown-item>
            <b-dropdown-item v-for="list in lists" :key="list.id" @click="addToList(list)">
                <span v-if="list.name === favouriteListName && list.is_default">
                    {{ $t('place_page.top_info.favourite') }}
                </span>
                <span v-else>
                    {{ list.name }}
                </span>
                <i
                    class="fas fa-check checkmark has-text-success"
                    v-if="checkedIn(list.places)"
                />
            </b-dropdown-item>
        </template>
    </b-dropdown>
</template>

<script>
import {mapGetters, mapActions, mapState} from 'vuex';
import {FAVOURITE_LIST_NAME} from '@/services/userList/listNames';

export default {
    name: 'TopInfoUserListItem',
    props: {
        lists: {
            type: Array,
            required: true,
        },
        place: {
            type: Object,
            required: true
        }
    },
    computed: {
        ...mapGetters('auth', ['getAuthenticatedUser']),
        ...mapState('userList', ['favouriteExist']),
        favouriteListName() {
            return FAVOURITE_LIST_NAME;
        }
    },
    methods: {
        ...mapActions('userList', [
            'addPlaceToList',
            'removePlaceFromList',
            'addPlaceToFavouriteList'
        ]),
        addToList: function (list) {
            if (this.checkedIn(list.places)) return;//no action if place already checked in
            this.addPlaceToList({
                listId: list.id,
                placeId: this.place.id,
                userId: this.getAuthenticatedUser.id
            })
                .then(
                    () => {
                        this.showToast(true,this.$t('place_page.message.added-to-list'));
                    },
                    () => {
                        this.showToast(false);
                    }
                );
        },
        addToFavouriteList: function () {
            this.addPlaceToFavouriteList({
                placeId: this.place.id,
                userId: this.getAuthenticatedUser.id
            })
                .then(
                    () => {
                        this.showToast(true,this.$t('place_page.message.added-to-list'));
                    },
                    () => {
                        this.showToast(false);
                    }
                );
        },
        checkedIn(listPlaces) {
            return listPlaces.includes(this.place.id);
        },
        showToast: function (success,message) {
            if (success) {
                this.$toast.open({
                    message: message,
                    type: 'is-success'
                });
            } else {
                this.$toast.open({
                    message: 'Whoops, something went wrong...',
                    type: 'is-danger'
                });
            }
        }
    }
};
</script>

<style lang="scss" scoped>
    .checkmark {
        margin-left: auto;
    }
    .dropdown-item{
        display: flex;
        width: 100%;
        padding-right:10px;
    }
</style>