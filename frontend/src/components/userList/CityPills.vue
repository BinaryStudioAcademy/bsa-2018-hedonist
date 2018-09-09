<template>
    <div class="has-text-center">
        <ul>
            <li
                v-for="(city, key, index) in cities.byId"
                class="city"
                :class="{added: isChecked(city.id), pop: isAnimated(city.id), popin: !isClicked(city.id)}"
                :key="index"
                :style="{ animationDelay: index * 0.02 + 's' }"
            >
                <div
                    class="pill"
                    @click="checkCity(city.id)"
                >
                    {{ city.name }}
                    <i v-if="isChecked(city.id)" class="fas fa-check" />
                    <i v-else class="fas fa-plus" />
                </div>
            </li>
            <li
                class="city"
                :class="{added: isSelected(), pop: isSelected(), popin: isSelected()}"
                :key="cities.byId.length"
                :style="{ animationDelay: cities.byId.length * 0.02 + 's' }"
            >
                <div
                    class="pill"
                    @click="clearSelected"
                >
                    {{ $t('user_lists_page.city_pills.clear_filter') }}
                    <i class="far fa-trash-alt" />
                </div>
            </li>
        </ul>
    </div>
</template>

<script>
import { mapState, mapGetters } from 'vuex';

export default {
    name: 'CityPills',
    data() {
        return {
            timeDelay: 0,
            selectedIds: [],
            citiesData: [],
        };
    },
    props: {
        cities: {
            required: true,
            type: Object,
        },
    },
    methods: {
        checkCity(id) {
            if (this.citiesData[id] === undefined) {
                this.citiesData[id] = {
                    check: false,
                    isClick: false,
                    isAnimate: false
                };
            }
            let cityData = this.citiesData[id];
            if (!this.selectedIds.includes(id)) {
                this.addCity(id);
            } else {
                this.deleteCity(id);
            }
            cityData.isClick = true;
            cityData.isAnimate = true;
            setTimeout(function () {
                cityData.isAnimate = false;
            }, 200);
            this.$emit('filter',this.selectedIds);
        },
        clearSelected(){
            this.selectedIds=[];
            this.$emit('filter',this.selectedIds);
        },
        deleteCity(id) {
            this.citiesData[id].check = false;
            this.selectedIds.splice(this.selectedIds.indexOf(id), 1);
        },
        addCity(id) {
            this.citiesData[id].check = true;
            this.selectedIds.push(id);
        },
        isSelected(){
            return this.selectedIds.length !== 0;
        },
        isChecked(id) {
            return this.selectedIds.includes(id);
        },
        isAnimated(id) {
            return this.citiesData !== undefined || this.citiesData[id].isAnimate;
        },
        isClicked(id) {
            return this.citiesData !== undefined || this.citiesData[id].isClick;
        },
    },
    computed: {
    },
    created() {
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

    .city {
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

    .city.added {
        .pill {
            background: #f94877;
        }
    }

    .city.popin {
        animation-name: popin;
    }

    .city.pop {
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

    .city-input {
        width: 300px;
        margin-top: 30px;
    }
</style>