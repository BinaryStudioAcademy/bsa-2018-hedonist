<template>
    <div class="places">
        <div
            v-click-outside="hideSearchList"
            class="search-places"
        >
            <div class="search-inputs">
                <div class="search-inputs__location">
                    <SearchCity
                        @select="selectCity"
                        :no-redirect = "noRedirect"
                    />
                </div>
                <div :class="['search-inputs__name', 'control', searchInputLoadingClass]">
                    <input
                        placeholder="Search places"
                        type="text"
                        v-model.trim="searchName"
                        @focus="searchPlaces()"
                        class="search-field input"
                        @input="searchPlaces()"
                    >
                </div>
            </div>
            <div class="search-places__list" v-show="displayList && !isPlaceFetching">
                <ul v-if="places.length > 0">
                    <li
                        v-for="place in places"
                        :key="place.id"
                        class="search-places__item"
                        @click="attachPlace(place)"
                    >
                        <div class="search-places__img-wrapper">
                            <img
                                class="search-places__img place-image"
                                :src="getPlacePhoto(place)"
                                :alt="getPlacePhotoDescription(place)"
                            >
                        </div>
                        <div class="search-places__details">
                            <div class="search-places__name">{{ getPlaceName(place) }}</div>
                            <div>
                                <span class="search-places__city">{{ place.city.name }}</span>,&nbsp;
                                <span class="search-places__category">{{ place.category.name }}</span>
                            </div>
                            <div class="search-places__description">{{ place.address }}</div>
                        </div>
                        <div class="search-places__rating">
                            <span :class="['place-rating','place-rating--' + ratingModifier(place.rating)]">
                                {{ place.rating }}
                            </span>
                        </div>
                    </li>
                </ul>
                <div v-else class="search-places__none">No places found</div>
            </div>
        </div>
        <div class="attached-places">
            <ul class="attached-places__list" v-if="attachedPlaces.length > 0">
                <li
                    class="attached-places__item"
                    v-for="(place, index) in attachedPlaces"
                    :key="index"
                >
                    <button
                        class="attached-places__detach button is-danger is-large"
                        @click="detachPlace(place)"
                    >
                        -
                    </button>
                    <div class="attached-places__img-wrapper">
                        <img
                            class="attached-places__img place-image"
                            :src="getPlacePhoto(place)"
                            :alt="getPlacePhotoDescription(place)"
                        >
                    </div>
                    <div class="attached-places__details">
                        <div class="attached-places__name">{{ getPlaceName(place) }}</div>
                        <div class="attached-places__city">{{ place.city.name }}</div>
                        <div class="attached-places__category">{{ place.category.name }}</div>
                        <div class="attached-places__description">{{ place.address }}</div>
                    </div>
                    <div class="attached-places__rating">
                        <span :class="['place-rating','place-rating--' + ratingModifier(place.rating)]">
                            {{ place.rating }}
                        </span>
                    </div>
                </li>
            </ul>
            <div v-else class="attached-places__none">You may attach some places to the list</div>
        </div>
    </div>
</template>

<script>
import { mapActions } from 'vuex';
import SearchCity from '@/components/navbar/SearchCity';
import LocationService from '@/services/location/locationService';
import mapSettingsService from '@/services/map/mapSettingsService';

export default {
    name: 'SearchPlaces',
    components: {
        SearchCity
    },
    props: {
        listAttachedPlaces: {
            type: Array,
            required: true
        },
    },
    data: function() {
        return {
            searchName: '',
            displayList: false,
            attachedPlaces: [],
            location: {
                lat: 50.4547,
                lng: 30.5238
            },
            places: [],
            isPlaceFetching: false,
            noRedirect: {
                redirect: false
            }
        };
    },
    created() {
        LocationService.getUserLocationData()
            .then(({lng, lat}) => {
                this.location = {lng, lat};
            });
    },
    computed: {
        searchInputLoadingClass() {
            return this.isPlaceFetching ? 'is-loading' : false;
        }
    },
    watch: {
        'attachedPlaces': function() {
            this.$emit('changeAttachedPlaces', this.attachedPlaces);
        },
        'listAttachedPlaces': function() {
            this.attachedPlaces = this.listAttachedPlaces;
        }
    },
    methods: {
        ...mapActions({ fetchPlaces: 'place/fetchPlaces' }),
        searchPlaces: _.debounce(function() {
            this.isPlaceFetching = true;
            this.fetchPlaces({
                location: `${this.location.lng},${this.location.lat}`,
                name: this.searchName
            }).then((res) => {
                this.displayList = true;
                this.isPlaceFetching = false;
                this.places = this.filterPlaces(res.data.data);
            });
        }, 500),
        hideSearchList() {
            this.displayList = false;
        },
        attachPlace(place) {
            this.attachedPlaces.push(place);
            this.places = this.filterPlaces(this.places);
        },
        detachPlace(detachedPlace) {
            this.attachedPlaces = _.xorBy(this.attachedPlaces, [detachedPlace], 'id');
        },
        filterPlaces(places) {
            return _.differenceBy(places, this.attachedPlaces, 'id');
        },
        ratingModifier(rating) {
            if (rating >= 7) {
                return 'good';
            }

            if (rating >= 5) {
                return 'okay';
            }

            return 'bad';
        },
        getPlaceName(place) {
            return place.localization[0].name;
        },
        getPlacePhoto(place) {
            return place.photos[0]['img_url'];
        },
        getPlacePhotoDescription(place) {
            return place.photos[0]['description'];
        },
        selectCity(city) {
            if (city && city.center) {
                this.location = {
                    lng: city.center[0],
                    lat: city.center[1]
                };
                this.searchPlaces();
            }
        }
    }
};
</script>

<style lang="scss">
    .search-inputs__location {
        .location-search {
            display: none;
        }
    }
</style>

<style lang="scss" scoped>
    .place-rating {
        border-radius: 7px;
        background-color: black;
        color: #fff;
        padding: 10px;

        &--bad {
            background-color: #FC8D9F;
        }

        &--okay {
            background-color: #FFA500;
        }

        &--good {
            background-color: #00B551;
        }
    }

    .place-image {
        border-radius: 5px;
        width: 100%;
        height: 100%;
        object-fit: cover;
        object-position: 50% 50%;
    }

    .places {
        grid-area: places;
        background-color: white;

        .search-places {
            position: sticky;
            top: 264px;
            background: #f0f4f5;
            border-bottom: 1px solid #dae4e6;
            border-top: 1px solid #dae4e6;
            padding: 10px;

            .search-inputs {
                display: block;

                &__name {
                    width: 100%
                }

                &__location {
                    padding-bottom: 5px;
                }
            }

            &__none {
                padding: 20px;
                font-weight: bold;
            }

            &__item {
                line-height: 16px;
                overflow: hidden;
                background: #fff;
                cursor: pointer;
                display: flex;
                padding: 5px 10px;
                text-decoration: none;

                &:hover {
                    background: #f5f5f5;
                }
            }

            &__list {
                z-index: 1;
                position: absolute;
                width: calc(100% - 20px);
                max-height: 200px;
                overflow-y: auto;
                top: 47px;
                background: #fff;
                border: 1px solid #3990bb;
                border-top: none !important;
                box-shadow: rgba(0, 0, 0, 0.1) 0 0 2px 0;
                border-radius: 0 0 5px 5px;
                vertical-align: baseline;
            }

            &__details {
                display: flex;
                flex-direction: column;
                margin-left: 5px;
            }

            &__rating {
                margin-left: auto;
                align-self: center;

                .place-rating {
                    font-size: 18px;
                }
            }

            &__name {
                color: #333;
                font-weight: bold;
                overflow: hidden;
                text-overflow: ellipsis;
                font-size: 0.9rem;
            }

            a:hover .search-places__name {
                color: #2d5be3;
            }

            &__description {
                color: #999;
                font-weight: normal;
                overflow: hidden;
                text-overflow: ellipsis;
                font-size: 0.9rem;
            }

            &__img-wrapper {
                flex-shrink: 0;
                width: 80px;
                height: 50px;
            }
        }

        .attached-places {
            padding: 10px;

            &__none {
                font-size: 24px;
                text-align: center;
                font-weight: bold;
            }

            &__item {
                display: flex;
                align-items: center;
                margin: 15px 0;
            }

            &__img-wrapper {
                flex-shrink: 0;
                width: 180px;
                height: 128px;
            }

            &__details {
                margin-left: 15px;
            }

            &__name {
                font-size: 22px;
                font-weight: bold;
            }

            &__detach {
                margin-right: 15px;
                position: initial;
            }

            &__rating {
                margin-left: auto;

                .place-rating {
                    font-size: 25px;
                    padding: 20px;
                }
            }
        }
    }


    @media screen and (max-width: 769px) {
        .places {
            .search-places {
                position: relative;
                top: 0;
            }
        }
    }
</style>