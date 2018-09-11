<template>
    <b-modal 
        :active.sync="toShow" 
        :width="640" 
        scroll="keep" 
        :on-cancel="cancel"
    >
        <div class="box userlist-modal">
            <h5 class="title is-5">{{ $t('my-lists_page.delete-confirmation') }} "{{ userList.name }}"?</h5>
            <div class="buttons is-centered">
                <button class="button is-info" @click="cancel">{{ $t('my-lists_page.buttons.cancel') }}</button>
                <button class="button is-danger" @click="onDelete">{{ $t('buttons.delete') }}</button>
            </div>
        </div>
    </b-modal>
</template>

<script>
import { mapActions } from 'vuex';

export default {
    name: 'DeleteModal',
    data() {
        return {
            toShow: this.show
        };
    },
    props: {
        userList: {
            required: true,
            type: Object
        },
        show: Boolean
    },
    methods: {
        ...mapActions({ delete: 'userList/deleteUserList' }),
        onDelete() {
            this.$emit('preloader');
            this.delete(this.userList.id)
                .then(() => {
                    this.$toast.open({
                        message: 'The list was removed',
                        position: 'is-top',
                        type: 'is-info'
                    });
                });
        },
        cancel() {
            this.$emit('close');
        }
    }
};
</script>

<style scoped>
    .userlist-modal {
        max-width: 640px;
        text-align: center;
        overflow-wrap: break-word;
    }
</style>