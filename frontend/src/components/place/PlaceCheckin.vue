<template>
    <button
            class="button is-primary"
            @click="checkinPlace"
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
            },

            placeId: {
                required: true,
                type: Number
            }
        },

        computed: {
            checkinCount() {
                return this.checkins;
            },
        },

        methods: {
            ...mapActions('history', ['checkIn']),

            checkinPlace: function() {
                this.checkIn({
                    place_id: this.placeId
                })
                    .then(() => {
                        this.$toast.open({
                            type: 'is-success',
                            message: 'Checked in'
                        });
                    })
                    .catch((response) => {
                        this.handleError(response);
                    });
            },
        }
    };
</script>

<style lang="scss" scoped>

</style>
