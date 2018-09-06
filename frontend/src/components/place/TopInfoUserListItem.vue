<template>
    <b-dropdown>
        <button class="button is-success" slot="trigger">
            <i class="far fa-save" />{{ $t('place_page.buttons.save') }}
            <b-icon icon="menu-down" />
        </button>
        <template v-if="lists.length">
            <template v-for="list in lists">
                <b-dropdown-item :key="list.id" @click="addToList(list)">
                    {{ list.name }}
                    <i
                        class="fas fa-check checkmark has-text-success"
                        v-if="checkedIn(list.places)"
                    />
                </b-dropdown-item>
            </template>
        </template>
        <template v-else>
            <b-dropdown-item>
                {{ $t('place_page.message.no-lists') }}
            </b-dropdown-item>
        </template>
    </b-dropdown>
</template>


<script>
import {mapGetters, mapActions} from 'vuex';

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
    },
    methods: {
        ...mapActions('userList', ['addPlaceToList']),
        addToList: function (list) {
            if (this.checkedIn(list.places)) return;//no action if place already checked in
            this.addPlaceToList({
                listId: list.id,
                placeId: this.place.id,
                userId: this.getAuthenticatedUser.id
            })
                .then(
                    () => {
                        this.showToast(true);
                    },
                    () => {
                        this.showToast(false);
                    }
                );
        },
        checkedIn(listPlaces) {
            return listPlaces.includes(this.place.id);
        },
        showToast: function (success) {
            if (success) {
                this.$toast.open({
                    message: this.$t('place_page.message.added-to-list'),
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