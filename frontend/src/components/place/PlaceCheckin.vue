<template>
    <button
            class="button is-primary"
            @click="checkinPlace"
    >
        <i class="fas fa-clock"></i> {{ checkinCount }}
    </button>
</template>

<script>
    import { mapActions } from 'vuex';

    export default {
        name: 'PlaceCheckin',

        props: {
            place: {
                required: true,
                type: Object
            }
        },

        data() {
            return {
                checkins: 0
            };
        },

        created() {
            this.checkins = this.place.checkins;
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
                    place_id: this.place.id
                })
                    .then(() => {
                        this.checkins++;
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
