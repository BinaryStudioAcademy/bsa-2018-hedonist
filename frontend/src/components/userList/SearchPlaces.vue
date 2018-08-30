<template>
    <div class="places">
        <div
            v-click-outside="hideSearchList"
            :class="['search-places control', searchInputLoadingClass]"
        >
            <input
                placeholder="Search places"
                type="text"
                v-model.trim="searchName"
                @focus="searchPlaces"
                class="search-field input"
                @input="searchPlaces"
            >
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
                            <div class="search-places__city">{{ place.city.name }}</div>
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

export default {
    name: "SearchPlaces",
    props: {
        attachedPlaces: {
            type: Array,
            required: true
        }
    },
    data: function() {
        return {
            searchName: '',
            displayList: false,
            placesLocation: '30.5241,50.4501',
            places: [],
            isPlaceFetching: false,
        }
    },
    computed: {
        searchInputLoadingClass() {
            return this.isPlaceFetching ? 'is-loading' : false;
        }
    },
    watch: {
        'attachedPlaces': function() {
            this.$emit('changeAttachedPlaces', this.attachedPlaces);
        }
    },
    methods: {
        ...mapActions({ fetchPlaces: 'place/fetchPlaces' }),
        searchPlaces() {
            this.isPlaceFetching = true;
            this.fetchPlaces({
                location: this.placesLocation,
                searchName: this.searchName
            }).then((res) => {
                this.displayList = true;
                this.isPlaceFetching = false;
                this.places = this.filterPlaces(res.data.data);
            });
        },
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
    }
}
</script>

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

    .control.is-loading::after {
        right: 1.625em;
        top: 30px;
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

        .search-places {
            position: sticky;
            top: 264px;
            background: #f0f4f5;
            border-bottom: 1px solid #dae4e6;
            border-top: 1px solid #dae4e6;
            padding: 20px;

            .search-field {
                padding: 10px;
                width: 100%;
                font-size: 1.1rem;
                transition-duration: .33s;
                transition-property: background, border, color, opacity, box-shadow;
                border-radius: 3px;
                border-bottom-left-radius: 0;
                border-bottom-right-radius: 0;
                color: #000;
                letter-spacing: 0;
                background: #fff;
                border: 1px solid #c7cdcf;
                outline: none;
            }

            &__none {
                padding: 20px;
                font-weight: bold;
            }

            &__item {
                line-height: 16px;
                overflow: hidden;
                white-space: nowrap;
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
                width: calc(100% - 40px);
                max-height: 200px;
                overflow-y: auto;
                top: 64px;
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
</style>