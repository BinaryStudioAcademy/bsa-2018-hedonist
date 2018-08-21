<template>
    <div class="container">
        <ul>
            <b-taginput
                    v-model="selectedTastes"
                    field="name"
                    autocomplete
                    :data="tastes"
                    type="is-info"
                    rounded
                    icon="label"
                    placeholder="Add a taste">
            </b-taginput>
        </ul>
        <button class="doneButton loggedOut">Save</button>
    </div>
</template>

<script>
import {mapState} from 'vuex';

export default {
    name: 'TasteList',
    data() {
        return {
            timeDelay: 0,
            selectedTastes: [],
        };
    },
    methods: {
        checkTaste(index) {
            let taste = this.tastes[index];
            taste.check = !taste.check;
            taste.isClick = true;
            taste.isAnimate = true;
            setTimeout(function () {
                taste.isAnimate = false;
            }, 200);
        }
    },
    computed: {
        ...mapState('taste', ['tastes'])
    },
    created() {
        this.$store.dispatch('taste/fetchTastes');
    },
};
</script>

<style lang="scss" scoped>
    @keyframes popin {
        0% {
            transform: scale(0)
        }
        50% {
            transform: scale(1.1)
        }
        100% {
            transform: scale(1)
        }
    }

    @keyframes pop {
        0% {
            transform: scale(1.02)
        }
        50% {
            transform: scale(.9)
        }
        100% {
            transform: scale(1)
        }
    }

    .container {
        border-radius: 3px;
        background: #fff;
        position: relative;
        text-align: center;
        padding: 80px 30px;
    }

    .taste {
        animation-fill-mode: both;
        animation-duration: .2s;
        animation-iteration-count: 1;
        animation-timing-function: ease;

        display: inline-block;
        margin: 0 5px 7px 5px;

        .pill {
            border-radius: 100px;
            background: #2d5be3;
            color: #fff;
            cursor: pointer;
            font-size: 0.9rem;
            line-height: 100%;
            padding: 7px 10px 7px 12px;
            position: relative;

            i {
                margin-left: 5px;
            }
        }
        .pill:hover {
            top: -1px;
        }
    }

    .taste.added {
        .pill {
            background: #f94877;
        }
    }

    .taste.popin {
        animation-name: popin;
    }

    .taste.pop {
        animation-name: pop;
    }

    .doneButton {
        font-size: 1rem;
        letter-spacing: 0;
        box-shadow: none;
        border-radius: 5px;
        background: #2d5be3;
        border: none;
        clear: both;
        color: #fff;
        cursor: pointer;
        font-weight: 500;
        padding: 15px;
        display: block;
        margin: 10px auto;
        text-align: center;
        width: 100px;
    }

    .doneButton:hover {
        background-color: #426be6;
    }
</style>