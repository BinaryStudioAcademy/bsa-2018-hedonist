<template>
    <form @submit.prevent>
        <div class="modal-card" style="width: auto">
            <header class="modal-card-head">
                <p class="modal-card-title">Rate place</p>
            </header>
            <section class="modal-card-body" @mouseover="showUserRating">
                <div class="smileys" @click="setUserRating">
                    <i data-value="1" class="far fa-angry fa-2x"></i>
                    <i data-value="2" class="far fa-frown-open fa-2x"></i>
                    <i data-value="3" class="far fa-frown fa-2x"></i>
                    <i data-value="4" class="far fa-meh-rolling-eyes fa-2x"></i>
                    <i data-value="5" class="far fa-meh fa-2x"></i>
                    <i data-value="6" class="far fa-smile fa-2x"></i>
                    <i data-value="7" class="far fa-grin fa-2x"></i>
                    <i data-value="8" class="far fa-smile-beam fa-2x"></i>
                    <i data-value="9" class="far fa-laugh fa-2x"></i>
                    <i data-value="10" class="far fa-laugh-beam fa-2x"></i>
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
import { mapActions } from 'vuex';

export default {
    name: 'PlaceCheckinModal',

    data: function() {
        return {
            userRating: ''
        }
    },

    props: {
        place: {
            type: Object,
            required: true
        }
    },

    methods: {
        ...mapActions('place', ['checkIn', 'setPlaceRating']),

        showUserRating: function(event) {
            const hoveredElem = event.target;
            
            if (hoveredElem.tagName != 'I') {
                this.userRating = '';
            }

            this.userRating = hoveredElem.dataset.value;
        },

        setUserRating: function(event) {            
            if (event.target.tagName != 'I') {
                return;
            }

            this.checkIn({
                place_id: this.place.id
            }).then((res) => {
                if (res.error) {
                    this.$toast.open({
                        type: 'is-danger',
                        message: res.error.message
                    });
                } else {
                    this.$toast.open({
                        type: 'is-success',
                        message: 'Checked in'
                    });
                }
            });

            this.setPlaceRating({
                place_id: this.place.id,
                rating: this.userRating,
                user_id: this.$store.state.auth.currentUser.id
            }).then((res) => {
                if (res.error) {
                    this.$toast.open({
                        type: 'is-danger',
                        message: res.error.message
                    });
                } else {
                    this.$toast.open({
                        type: 'is-success',
                        message: 'Rating set'
                    });
                }
            });

            this.$parent.close();
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
            margin-right: 25px;

            i {
                border-radius: 50%;

                &:hover {
                    background-color: yellow;
                    cursor: pointer;
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
