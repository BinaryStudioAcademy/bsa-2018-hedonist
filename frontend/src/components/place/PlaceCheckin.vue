<template>
    <button
            class="button is-primary"
            @click=""
    >
        <i class="fas fa-clock"></i> {{ checkinCount }}
    </button>
</template>

<script>
    export default {
        name: 'PlaceCheckin',

        props: {
            checkins: {
                required: true,
                type: Number
            }
        },

        computed: {
            checkinCount() {
                return this.checkins;
            },
        }
    };
</script>

<style lang="scss" scoped>

</style>
