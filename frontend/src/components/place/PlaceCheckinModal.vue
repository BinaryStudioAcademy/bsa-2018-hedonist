<template>
    <form @submit.prevent>
        <div class="modal-card" style="width: auto">
            <header class="modal-card-head">
                <p class="modal-card-title">Rate place</p>
            </header>
            <section class="modal-card-body">
                <div class="smileys">
                    <Smiley
                        v-for="(icon, index) in icons"
                        :key="index + 1"
                        :value="index + 1"
                        :icon="icon"
                        @onHover="onHover"
                        @onSelect="onSelect"
                    />
                </div>

                <span class="rating">{{ userRating }}/10</span>
            </section>
            <footer class="modal-card-foot">
                <button class="button" type="button" @click="$parent.close()">Close</button>
            </footer>
        </div>
    </form>    
</template>

<script>
import { mapActions, mapGetters } from 'vuex';
import Smiley from '../misc/Smiley';

export default {
    name: 'PlaceCheckinModal',

    components: {
        Smiley
    },

    data: function() {
        return {
            userRating: '',

            icons: [
                'fa-angry',
                'fa-frown-open',
                'fa-frown',
                'fa-meh-rolling-eyes',
                'fa-meh',
                'fa-smile',
                'fa-grin',
                'fa-smile-beam',
                'fa-laugh',
                'fa-laugh-beam'
            ]
        }
    },

    props: {
        place: {
            type: Object,
            required: true
        }
    },

    computed: {
        ...mapGetters('auth', ['getAuthenticatedUser'])
    },

    methods: {
        ...mapActions('place', ['checkIn', 'setPlaceRating']),

        onHover: function(value) {
            this.userRating = value;
        },

        onSelect: function(value) {
            this.checkIn({
                place_id: this.place.id
            }).then((response) => {
                this.handleResponse(response, 'Checked in');
            });

            this.setPlaceRating({
                place_id: this.place.id,
                rating: value,
                user_id: this.getAuthenticatedUser.id
            }).then((response) => {
                this.handleResponse(response, 'Rating set');
            });

            this.$parent.close();
        },

        handleResponse: function(response, successMessage) {
            switch (response.status) {
                case 201:
                    this.$toast.open({
                        type: 'is-success',
                        message: successMessage
                    });
                    break;
                case 400:
                    this.$toast.open({
                        type: 'is-danger',
                        message: response.statusText
                    });
                    break;
                default:
                    this.$toast.open({
                        type: 'is-danger',
                        message: 'Something went wrong. Try again later'
                    });
            }
        }
    }
}
</script>

<style lang="scss" scoped>
    .modal-card-title {
        text-align: center;
    }
    
    .modal-card-body {
        display: flex;
        justify-content: space-between;
        width: 460px;

        .smileys {
            display: inline-block;

            i {
                margin-right: 5px;

                &:last-child {
                    margin-right: 0;
                }
            }
        }

        .rating {
            align-self: center;
        }
    }

    .chosenRating {
        background-color: yellow;
    }
</style>
