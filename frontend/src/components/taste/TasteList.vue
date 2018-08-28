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
        <b-field label="My own">
            <b-taginput
                v-model="customTastes"
                ellipsis
                icon="label"
                type="is-info"
                placeholder="Add a taste"
                @add="addCustomTaste"
                @remove="deleteCustomTaste"
            />
        </b-field>
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
            customTastes: []
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
            if (this.selectedIds.includes(id)) {
                this.deleteTaste(id);
            } else {
                this.addTaste(id);
            }
            tasteData.isClick = true;
            tasteData.isAnimate = true;
            setTimeout(function () {
                tasteData.isAnimate = false;
            }, 200);
        },
        deleteTaste(id) {
            this.tastesData[id].check = false;
            this.$store.dispatch('taste/deleteMyTaste', id);
            this.selectedIds.splice(this.selectedIds.indexOf(id), 1);
        },
        addTaste(id) {
            this.tastesData[id].check = true;
            this.$store.dispatch('taste/addMyTaste', this.allTastes.byId[id]);
            this.selectedIds.push(id);
        },
        addCustomTaste(name) {
            this.$store.dispatch('taste/addCustomTaste', name);
        },
        deleteCustomTaste(name) {
            let taste = this.getTasteByName(name);
            if (taste) {
                this.$store.dispatch('taste/deleteCustomTaste', taste.id);
            }
        },
        isChecked(id) {
            return this.selectedIds.includes(id);
        },
        isAnimated(id) {
            return this.tastesData !== undefined || this.tastesData[id].isAnimate;
        },
        isClicked(id) {
            return this.tastesData !== undefined || this.tastesData[id].isClick;
        }
    },
    computed: {
        ...mapState('taste', ['allTastes', 'myTastes']),
        ...mapGetters('taste', ['getMyTastesIds', 'getAllTastesIds', 'getTasteByName'])
    },
    created() {
        this.$store.dispatch('taste/fetchTastes').then(() => {
            let customTastes = [];
            this.getAllTastesIds.forEach((id) => {
                if (this.allTastes.byId[id].user_id)
                    customTastes.push(this.allTastes.byId[id].name);
            });
            this.customTastes = customTastes;
        });
        this.$store.dispatch('taste/fetchMyTastes').then(() => {
            this.selectedIds = this.getMyTastesIds;
            this.selectedIds.forEach((item, i) => { this.selectedIds[i] = parseInt(item); });
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