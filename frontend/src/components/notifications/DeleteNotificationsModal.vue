<template>
    <div>
        <header class="modal-card-head">
            <p class="modal-card-title">{{ $t('notifications.confirm-deleting') }}</p>
        </header>
        <footer class="modal-card-foot">
            <button class="button" type="button" @click="$parent.close()">
                {{ $t('notifications.no') }}
            </button>
            <button class="button is-danger" @click="onDelete">
                {{ $t('notifications.yes') }}
            </button>
        </footer>
    </div>
</template>

<script>
export default {
    name: "DeleteNotificationsModal",
    methods: {
        onDelete() {
            this.$parent.close();
            this.$emit('onDelete');
        }
    }
}
</script>

<style scoped>
    .button.is-danger:hover {
        background-color: #ce143a;
    }
</style>