<template>
    <div class="notification-modal">
        <header class="modal-card-head">
            <p class="modal-card-title">{{ $t('notifications.confirm-deleting') }}</p>
        </header>
        <footer class="modal-card-foot">
            <div class="actions">
                <button class="button" type="button" @click="$parent.close()">
                    {{ $t('notifications.no') }}
                </button>
                <button class="button is-danger" @click="onDelete">
                    {{ $t('notifications.yes') }}
                </button>
            </div>
        </footer>
    </div>
</template>

<script>
export default {
    name: 'DeleteNotificationsModal',
    methods: {
        onDelete() {
            this.$parent.close();
            this.$emit('onDelete');
        }
    }
};
</script>

<style scoped>
    .notification-modal {
        text-align: center;
    }

    .modal-card-foot > .actions {
        margin: 0 auto;
    }

    .button.is-danger:hover {
        background-color: #ce143a;
    }
</style>