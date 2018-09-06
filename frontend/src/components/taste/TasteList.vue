<template>
    <div class="container">
        <ul>
            <li
                v-for="(taste, index) in allTastes.byId"
                class="taste"
                :class="{added: isChecked(taste.id), pop: isAnimated(taste.id), popin: !isClicked(taste.id)}"
                :key="taste.id"
                :style="{ animationDelay: index * 0.02 + 's' }"
            >
                <div class="pill" @click="checkTaste(taste.id)">
                    {{ taste.name }}
                    <i v-if="isChecked(taste.id)" class="fas fa-check" />
                    <i v-else class="fas fa-plus" />
                </div>
            </li>
        </ul>
        <b-autocomplete
            class="taste-input"
            rounded
            v-model.trim="tasteInput.text"
            placeholder="Enter a tag"
            :loading="tasteInput.isFetching"
            :data="tasteInput.data"
            @input="loadTags"
            @select="option => selected = option"
            @keyup.native.enter="addCustomTaste(tasteInput.text)"
            maxlength="20"
            minlength="3"
        />
    </div>
</template>

<script>
import { mapState, mapGetters } from 'vuex';

export default {
    name: 'TasteList',
    data() {
        return {
            timeDelay: 0,
            selectedIds: [],
            tastesData: [],
            tasteInput: {
                data: [],
                text: '',
                isFetching: false
            },
        };
    },
    methods: {
        checkTaste(id) {
            if (this.tastesData[id] === undefined) {
                this.tastesData[id] = {
                    check: false,
                    isClick: false,
                    isAnimate: false
                };
            }
            let tasteData = this.tastesData[id];
            if (!this.selectedIds.includes(id)) {
                this.addTaste(id);
            } else {
                this.deleteTaste(id);
            }
            if (this.allTastes.byId[id].is_default) {
                tasteData.isClick = true;
                tasteData.isAnimate = true;
                setTimeout(function () {
                    tasteData.isAnimate = false;
                }, 200);
            }
        },
        deleteTaste(id) {
            let taste = this.allTastes.byId[id];
            if (taste && taste.is_default) {
                this.tastesData[id].check = false;
                this.$store.dispatch('taste/deleteMyTaste', id).then(() => {
                    this.selectedIds.splice(this.selectedIds.indexOf(id), 1);
                });
            } else {
                this.deleteCustomTaste(id);
            }
        },
        addTaste(id) {
            this.tastesData[id].check = true;
            this.$store.dispatch('taste/addMyTaste', this.allTastes.byId[id]);
            this.selectedIds.push(id);
        },
        addCustomTaste(name) {
            if (name.length >= 3) {
                this.$store.dispatch('taste/addCustomTaste', name).then((res) => {
                    this.checkTaste(res.id);
                    this.tasteInput.text = '';
                }).catch(
                    err => this.onError()
                );
            } else {
                this.onError('Taste name must have at least 3 characters length');
            }
        },
        deleteCustomTaste(id) {
            this.$store.dispatch('taste/deleteCustomTaste', id).then(() => {
                this.selectedIds.splice(this.selectedIds.indexOf(id), 1);
            });
        },
        isChecked(id) {
            return this.selectedIds.includes(id);
        },
        isAnimated(id) {
            return this.tastesData !== undefined || this.tastesData[id].isAnimate;
        },
        isClicked(id) {
            return this.tastesData !== undefined || this.tastesData[id].isClick;
        },
        onError(msg = 'Taste name length is incorrect') {
            this.$toast.open({
                message: msg,
                type: 'is-danger'
            });
        },
        loadTags: _.debounce(function () {
            if(this.tasteInput.text !== '') {
                this.tasteInput.data = [];
                this.tasteInput.isFetching = true;
                this.$store.dispatch('taste/getTasteAutocomplete', this.tasteInput.text)
                    .then(res => {
                        this.tasteInput.data = res;
                        this.tasteInput.isFetching = false;
                    })
                    .catch(err => {
                        this.tasteInput.isFetching = false;
                    });
            }
        }, 250),
    },
    computed: {
        ...mapState('taste', ['allTastes', 'myTastes']),
        ...mapGetters('taste', [
            'getMyTastesIds',
            'getAllTastesIds'
        ])
    },
    created() {
        this.$store.dispatch('taste/fetchTastes');
        this.$store.dispatch('taste/fetchMyTastes').then(() => {
            this.selectedIds = this.getMyTastesIds.map(id => parseInt(id));
        });
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
        min-height: 350px;
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

    .taste-input {
        max-width: 300px;
        margin: 30px auto;
    }
</style>