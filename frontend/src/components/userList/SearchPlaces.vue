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
                        class="search-places__item media"
                        @click="attachPlace(place)"
                    >
                        <div class="search-places__img-wrapper">
                            <figure class="media-left image is-64x64">
                                <img
                                    class="search-places__img place-image"
                                    :src="place.photo.img_url"
                                    :alt="place.photo.description"
                                >
                            </figure>
                        </div>
                        <div class="search-places__details  media-content">
                            <div class="search-places__name">{{ getPlaceName(place) }}</div>
                            <div>
                                <span class="search-places__city">{{ place.city.name }}</span>,&nbsp;
                                <span class="search-places__category">{{ place.category.name }}</span>
                            </div>
                            <div class="search-places__description">{{ place.address }}</div>
                        </div>
                        <div class="media-right rating-wrapper ">
                            <PlaceRating
                                v-if="place.rating"
                                :value="Number(place.rating)"
                                :show-rating="false"
                                :rating-count="place.ratingCount"
                            />
                        </div>
                    </li>
                </ul>
                <div v-else class="search-places__none">
                    {{ $t('user_lists_page.search.empty') }}
                </div>
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
                        class="attached-places__detach is-small button is-danger"
                        @click="detachPlace(place)"
                    >
                        <i class="fas fa-minus" />
                    </button>
                    <div class="attached-places__img-wrapper">
                        <figure class="attached-places__img media-left image is-64x64">
                            <img
                                class=" place-image"
                                :src="place.photo.img_url"
                                :alt="place.photo.description"
                            >
                        </figure>

                    </div>
                    <div class="attached-places__details media-content">
                        <div class="attached-places__name">{{ getPlaceName(place) }}</div>
                        <div class="attached-places__city">{{ place.city.name }}</div>
                        <div class="attached-places__category">{{ place.category.name }}</div>
                        <div class="attached-places__description">{{ place.address }}</div>
                    </div>
                    <div class="media-right rating-wrapper ">
                        <PlaceRating
                            v-if="place.rating"
                            :value="Number(place.rating)"
                            :show-rating="false"
                            :rating-count="place.ratingCount"
                        />
                    </div>
                </li>
            </ul>
            <div v-else class="attached-places__none">
                {{ $t('user_lists_page.search.message') }}
            </div>
        </div>
    </div>
</template>

<script>
import { mapActions } from 'vuex';
import SearchCity from '@/components/navbar/SearchCity';
import PlaceRating from '@/components/place/PlaceRating';

export default {
    name: 'SearchPlaces',
    components: {
        SearchCity,
        PlaceRating,
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
            places: [],
            isPlaceFetching: false,
            noRedirect: {
                redirect: false
            },
            polygon: ''
        };
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
        ...mapActions({
            loadPlaces: 'search/loadPlaces'
        }),
        searchPlaces: _.debounce(function() {
            this.isPlaceFetching = true;
            this.loadPlaces({name: this.searchName, polygon: this.polygon})
                .then( res => {
                    this.displayList = true;
                    this.isPlaceFetching = false;
                    this.places = this.filterPlaces(res);
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
            if (rating >= 4) {
                return 'good';
            }

            if (rating >= 3) {
                return 'okay';
            }

            return 'bad';
        },
        getPlaceName(place) {
            return place.localization[0].name;
        },
        selectCity(city) {
            this.polygon = city ? this.createPolygonByBBox(city.bbox) : '';
            this.searchPlaces();
        },
        createPolygonByBBox(bbox) {
            const x1 = bbox[0];
            const y1 = bbox[1];
            const x2 = bbox[2];
            const y2 = bbox[3];

            return x1 + ',' + y1 + ';' + x2 + ',' + y1 + ';' + x2 + ',' + y2 + ';' + x1 + ',' + y2 + ';' + x1 + ',' + y1;
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
            top: 300px;
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
                justify-content: space-between;
                margin: 15px 0 0 15px;
                font-size:0.75em;
                border-bottom: 1px solid rgba(219, 219, 219, 0.5);
                padding-bottom: 5px;
            }

            &__img{
                position: initial;
            }

            &__name {
                font-size: 16px;
                font-weight: bold;
            }

            &__detach {
                margin-right: 40px;
                position: initial;
                @media screen and (max-width: 768px) {
                    margin-right: 15px;
                }
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