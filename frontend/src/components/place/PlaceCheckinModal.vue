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
                        :selected="isSelected(index + 1)"
                        @onHover="onHover"
                        @onOut="onOut"
                        @onSelect="onSelect"
                    />
                </div>

                <span class="rating">{{ userRating || place.myRating || 0 }}/10</span>
            </section>
            <footer class="modal-card-foot">
                <button class="button" type="button" @click="$parent.close()">Close</button>
            </footer>
        </div>
    </form>    
</template>

<script>
import { mapActions, mapGetters, mapState } from 'vuex';
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
        };
    },

    props: {
        place: {
            type: Object,
            required: true
        }
    },

    computed: {
        ...mapGetters('auth', [
            'getAuthenticatedUser'
        ]),
    },

    methods: {
        ...mapActions('place', [
            'checkIn',
            'setPlaceRating'
        ]),

        isSelected: function(rating) {
            if (this.place.myRating === rating) {
                return 'chosenRating';
            }
            return '';
        },

        onHover: function(value) {
            this.userRating = value;
        },

        onOut: function(value) {
            this.userRating = this.place.myRating;
        },

        onSelect: function(value) {
            this.checkIn({
                place_id: this.place.id
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

            this.setPlaceRating({
                place_id: this.place.id,
                rating: value,
                user_id: this.getAuthenticatedUser.id
            })
                .then(() => {
                    this.$toast.open({
                        type: 'is-success',
                        message: 'Rating set'
                    });
                })
                .catch((response) => {
                    this.handleError(response);
                });

            this.$parent.close();
        },

        handleError: function(response) {
            this.$toast.open({
                type: 'is-danger',
                message: response.statusText
            });
        }
    }
};
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
