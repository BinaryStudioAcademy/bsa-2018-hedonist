<template>
    <div class="place-top-info">
        <PlacePhotoList />
        <div class="place-venue columns">
            <div class="column is-two-thirds">
                <div class="place-venue__logo">
                    <img
                        src="https://ss3.4sqi.net/img/categories_v2/food/caucasian_88.png"
                        data-retina-url="https://ss3.4sqi.net/img/categories_v2/food/caucasian_512.png"
                        width="88"
                        height="88"
                    >
                </div>
                <div class="place-venue__prime-info">
                    <div v-if="place.localization" class="place-venue__place-name">{{ place.localization.name }}</div>
                    <div v-else class="place-venue__place-name">No localization</div>
                    <div class="place-venue__category">{{ place.category.name }}</div>
                    <div class="place-venue__city">
                        {{ place.city.name }}, <span class="place-zip">{{ place.zip }}</span>
                    </div>
                </div>
            </div>
            <div class="column is-one-third place-venue__actions">
                <button 
                    class="button is-primary"
                    @click="isCheckinModalActive = true"
                >
                    <i class="fas fa-check" />Check-in
                </button>
                <b-modal :active.sync="isCheckinModalActive" has-modal-card>
                    <PlaceCheckinModal :place="place" />
                </b-modal>

                <b-dropdown>
                    <button class="button is-success" slot="trigger">
                        <i class="far fa-save" />Save
                        <b-icon icon="menu-down" />
                    </button>

                    <template v-for="list in userlist">
                        <b-dropdown-item :key="list.id" @click="addPlaceToList(list.id)">{{ list.name }}</b-dropdown-item>
                    </template>
                </b-dropdown>

                <button class="button is-info">
                    <i class="far fa-share-square" />Share
                </button>
            </div>
        </div>
        <div class="place-top-info__sidebar columns">
            <div class="column is-two-thirds">
                <nav class="sidebar-actions tabs">
                    <ul>
                        <li
                            @click="changeTab(1)"
                            :class="{ 'is-active' : activeTab === 1}"
                        >
                            <a><span>Reviews (2)</span></a>
                        </li>
                        <li
                            @click="changeTab(2)"
                            :class="{ 'is-active' : activeTab === 2}"
                        >
                            <a><span>Photos (12)</span></a>
                        </li>
                    </ul>
                </nav>
            </div>
            <div class="column is-one-third place-rate">
                <div class="place-rate__mark">
                    <span>{{ place.rating | formatRating }}</span><sup>/<span>10</span></sup>
                </div>
                <div class="place-rate__mark-count">
                    {{ place.ratingCount || 1 }} marks
                </div>
                <div class="place-rate__preference">
                    <div class="likable like">
                        <span class="fa-stack fa-2x">
                            <i class="fa fa-heart fa-stack-1x" />
                        </span>
                    </div>
                    <div class="likable dislike">
                        <span class="fa-stack fa-2x">
                            <i class="fa fa-heart fa-stack-1x" />
                            <i class="fa fa-bolt fa-stack-1x fa-inverse" />
                        </span>
                    </div>
                </div>
            </div>
        </div>
    </div>
</template>

<script>
import PlacePhotoList from './PlacePhotoList';
import PlaceCheckinModal from './PlaceCheckinModal';

export default {
    name: 'PlaceTopInfo',
    components: {
        PlacePhotoList,
        PlaceCheckinModal
    },
    props: {
        place: {
            type: Object,
            required: true
        }
    },
    filters: {
        formatRating: function(number){
            return new Intl.NumberFormat(
                'en-US', {
                    minimumFractionDigits: 1,
                    maximumFractionDigits: 1,
                }).format(number);
        },
    },
    data() {
        return {
            activeTab: 1,
            userlist: {},
            isCheckinModalActive: false
        };
    },

    created() {
        this.$store.dispatch('userlist/getListsByUser', this.user.id)
            .then((result) => {
                this.userlist = result;
            });
    },

    computed: {
        user() {
            return this.$store.getters['auth/getAuthenticatedUser'];
        }
    },

    methods: {
        changeTab: function(activeTab) {
            this.activeTab = activeTab;
            this.$emit('tabChanged', activeTab);
        },

        addPlaceToList: function (listId) {
            this.$store.dispatch('userlist/addPlaceToList', {
                listId: listId,
                placeId: this.place.id
            });
        }
    }
};
</script>

<style lang="scss" scoped>
    .place-top-info {
        background-color: #fff;
        .column {
            padding: 0;
        }
        &__sidebar {
            margin-top: 20px;
            .sidebar-actions {
                background-color: #f7f7fa;
                margin-left: 12px;
                padding-top: 35px;
            }

            .tab-content {
                display: none;
            }
            .place-rate {
                padding-left: 50px;
                display: flex;
                align-items: center;
                &__mark {
                    border-radius: 3px;
                    color: white;
                    background-color: #00B551;
                    padding: 4px;
                }
                &__mark-count {
                    margin-left: 10px;
                    font-style: italic;
                }
                &__preference {
                    display: flex;
                    margin-left: auto;
                    margin-right: 30px;
                    .likable {
                        cursor: pointer;
                        &:hover {
                            color: black;
                        }
                    }
                    .fa-bolt {
                        top: -5%;
                        left: 2%;
                        font-size:70%;
                    }
                }
            }
        }
    }
    .place-venue {
        margin: 20px;
        &__logo {
            border-radius: 3px;
            background-color: #c7cdcf;
            line-height: 0;
            margin-right: 20px;
            max-width: 88px;
            overflow: hidden;
            float: left;
        }
        &__prime-info {
            display: inline-block;
        }
        &__place-name {
            font-size: 25px;
            font-weight: bold;
            margin-bottom: 10px;
        }
        &__actions {
            display: flex;
            align-items: flex-end;
            justify-content: flex-end;
            .button {
                margin-right: 15px;
                i {
                    margin-right: 5px;
                    font-size: 25px;
                }
            }
        }
    }

    @media screen and (max-width: 520px) {
        .place-venue {
            &__actions {
                justify-content: space-between;
                margin-top: 50px;
            }
        }
    }
    @media screen and (max-width: 370px) {
        .place-venue {
            &__actions {
                justify-content: center;
                flex-wrap: wrap;
            }
        }
    }
</style>
