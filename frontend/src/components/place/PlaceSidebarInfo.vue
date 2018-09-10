<template>
    <aside class="column is-one-third">
        <div class="place-sidebar">
            <div class="map-box">
                <PlaceMapMarker :place="place" />
            </div>
            <div class="place-sidebar__info">
                <div class="place-sidebar__venue">
                    <i class="place-sidebar__icon far fa-compass" />
                    <div v-if="place.localization" class="place-name"><strong>{{ place.localization.name }}</strong></div>
                    <div v-else class="place-name"><strong>No localization</strong></div>
                    <div class="place-address">
                        <span class="place-street">{{ place.address }}</span>,
                        <span class="place-city">{{ place.city.name }}</span>,
                        <span class="place-zip">{{ place.zip }}</span>,
                        <span class="place-country">Украина</span>
                    </div>
                </div>
                <div v-if="place.tags" class="place-sidebar__tags">
                    <i class="place-sidebar__icon fas fa-info-circle" />
                    <span
                        v-for="tag in place.tags"
                        class="tag"
                        :key="tag.id"
                    >
                        {{ tag.name }}
                    </span>
                </div>

                <div v-if="!!this.place.worktime.length" class="place-sidebar__worktime">
                    <i class="place-sidebar__icon far fa-clock" />
                    <div class="level is-flex-mobile">
                        <div class="level-left">
                            <span v-if="isOpen() === true" class="worktime-info--green">{{ $t('place_page.sidebar.open') }}</span>
                            <span v-else class="worktime-info--red">{{ $t('place_page.sidebar.close') }}</span>
                        </div>
                        <div class="level-right">
                            <a @click="isShowSchedule = !isShowSchedule">{{ $t('place_page.sidebar.schedule') }}</a>
                        </div>
                    </div>
                    <b-collapse :open="isShowSchedule">
                        <div class="notification">
                            <template v-for="item in place.worktime">
                                <div :key="item.id" class="level is-flex-mobile">
                                    <div class="level-left">
                                        <span>{{ $t('weekdays.' + item.day) }}</span>
                                    </div>
                                    <div class="level-right">
                                        <span>{{ displayTime(item.start) }} - {{ displayTime(item.end) }}</span>
                                    </div>
                                </div>
                            </template>
                        </div>
                    </b-collapse>
                </div>

                <div class="place-sidebar__phone">
                    <i class="place-sidebar__icon fas fa-phone" />
                    <a
                        class="phone-number"
                        :href="`tel:${place.phone}`"
                    >
                        {{ place.phone }}
                    </a>
                </div>
                <div v-if="place.website" class="place-sidebar__website">
                    <i class="place-sidebar__icon fas fa-globe" />
                    <a
                        target="_blank"
                        :href="place.website"
                    >
                        {{ place.website }}
                    </a>
                </div>
                <template v-if="place.placeInfo">
                    <div class="place-sidebar__social" v-if="place.placeInfo.facebook">
                        <i class="place-sidebar__icon fab fa-facebook-square" />
                        <a :href="place.placeInfo.facebook">{{ place.placeInfo.facebook }}</a>
                    </div>
                    <div class="place-sidebar__social" v-if="place.placeInfo.instagram">
                        <i class="place-sidebar__icon fab fa-instagram" />
                        <a :href="place.placeInfo.instagram">{{ place.placeInfo.instagram }}</a>
                    </div>
                </template>
            </div>
            <template v-if="place.features.length > 0">
                <div class="place-sidebar__features">
                    <h2 class="block-title">{{ $t('place_page.sidebar.features') }}</h2>
                    <transition-group name="features-list">
                        <div
                            v-for="(feature, index) in sortedFeatures"
                            v-show="!showLessFeatures || (index < 3)"
                            :key="feature.id"
                            class="place-sidebar__feature-list"
                        >
                            <div class="feature">
                                <div class="feature-name">{{ feature.name }}</div>
                                <div
                                    v-if="isActiveFeature(feature.id)"
                                    class="feature-info"
                                >
                                    <i class="fas fa-check" />
                                </div>
                                <div v-else class="feature-info-absent">
                                    <i class="fas fa-times" />
                                </div>
                            </div>
                        </div>
                    </transition-group>
                </div>
                <div @click="showLessFeatures = !showLessFeatures" class="place-sidebar__more-feature-btn">
                    {{ showLessFeatures? $t('place_page.buttons.more') : $t('place_page.buttons.less') }}
                </div>
            </template>
            <template v-if="recommendedPlaces.length">
                <h2 class="block-title">{{ $t('place_page.sidebar.recommendation') }}</h2>
                <template v-for="(recommendedPlace, index) in recommendedPlaces">
                    <PlacePreview
                        v-if="!isLoading"
                        :key="recommendedPlace.id"
                        :place="recommendedPlace"
                        :timer="50 * (index+1)"
                        :show-review="false"
                    />
                </template>
            </template>
        </div>
    </aside>
</template>

<script>
import moment from 'moment';
import PlaceMapMarker from './PlaceMapMarker';
import { mapGetters, mapActions } from 'vuex';
import PlacePreview from './PlacePreview';

export default {
    name: 'PlaceSidebarInfo',
    components: {
        PlaceMapMarker,
        PlacePreview
    },

    created() {
        this.fetchAllFeatures();
        this.fetchRecommendationPlaces(this.place.id)
            .then((res) => {
                this.isLoading = false;
                this.recommendedPlaces = res;
            });
    },

    props: {
        place: {
            type: Object,
            required: true
        }
    },

    computed: {
        ...mapGetters('features', ['specialFeaturesList']),

        sortedFeatures: function () {
            let result = [];
            const features = this.place.features.map(
                feature => feature.id
            );
            this.specialFeaturesList.forEach( feature => {
                features.includes(feature.id)
                    ? result.unshift(feature)
                    : result.push(feature);
            });

            return result;
        }
    },

    data() {
        return {
            isShowSchedule: false,
            isLoading: true,
            recommendedPlaces: [],
            showLessFeatures: true
        };
    },

    methods: {
        ...mapActions('features', ['fetchAllFeatures']),
        ...mapActions('place', ['fetchRecommendationPlaces']),

        isActiveFeature: function (featureId) {
            return this.place.features.map(
                (feature) => feature.id
            ).indexOf(featureId)>=0;
        },

        isOpen() {
            let today = moment().format('dd').toLowerCase();
            let now = this.getMinutes(moment.utc());
            let today_schedule = this.place.worktime.find(function(item) {
                return item.day === today;
            });
            return this.getMinutes(moment(today_schedule.start)) < now
                && now < this.getMinutes(moment(today_schedule.end));
        },
        displayTime(time) {
            let localTime = this.getLocalMoment(time);
            return localTime.format('HH:mm');
        },
        getLocalMoment(time) {
            let utcTime = moment.utc(time);
            return utcTime.local();
        },
        getMinutes(momentObj) {
            return momentObj.hours() * 60 + momentObj.minutes();
        }
    }
};
</script>

<style lang="scss" scoped>
    .features-list-enter-active, .features-list-leave-active{
        transition: all 2s;
    }
    .features-list-enter {
        opacity: 0;
    }
    .features-list-leave-to {
        display:none;
    }

    .place-sidebar {
    background-color: #fff;

    .place-address {
        overflow-wrap: break-word;
    }

    .map-box {
        padding: 10px;

        img {
            width: 100%;
        }
    }

    &__info {
        > div {
            margin: 15px 25px 15px 50px;
            position: relative;
            padding-bottom: 10px;
            border-bottom: 1px solid lightgray;

            &:last-child {
                border: none;
            }
        }
    }

    &__icon {
        position: absolute;
        top: 5px;
        left: -25px;
    }

    &__worktime {
        .level {
            flex-wrap: wrap;
            margin-bottom: 5px;
        }
        .level-left {
            min-width: 85px;
        }

        .worktime-info {
            &--red {
                color: red;
            }
            &--green {
                color: green;
            }
        }
    }

    @media only screen and (max-width: 768px) {
        .level-right {
            margin-top: 0;
        }
    }

    .block-title {
        font-weight: bold;
        padding: 20px;
        background-color: #f7f7fa;
        border-bottom: 1px solid #efeff4;
        border-top: 1px solid #efeff4;
    }

    &__features {
        .feature {
            display: flex;
            flex-direction: row;
            justify-content: space-between;
            padding: 10px 20px;
            border-bottom: 1px solid #efeff4;

            .feature-name {
                flex: 80%;
            }

            .feature-info {
                flex: 20%;
                text-align: right;
                color: greenyellow;
            }

            .feature-info-absent {
                flex: 20%;
                text-align: right;
                color: indianred;
                padding-right: 3px;
            }
        }
    }

    &__more-feature-btn {
        padding: 10px 20px;
        text-align: center;
        color: #167df0;
        cursor: pointer;
    }

    &__social, &__website a {
        word-wrap: break-word;
    }

    &__tags {
        line-height: 30px;

        .tag {
            margin-right: 5px;
            color: white;
            background-color: #167df0;
            cursor: pointer;
        }
    }
}

</style>
