<template>
    <div class="place-top-info">
        <PlacePhotoList :photos="place.photos" @showAllPhotos="changeTab(2)" />
        <div class="place-venue columns">
            <div class="column is-two-thirds">
                <div class="place-venue__logo">
                    <img
                        :src="placeMarker"
                        width="88"
                        height="88"
                    >
                </div>
                <div class="place-venue__prime-info">
                    <div class="place-venue__place-name">{{ localizedName }}</div>
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
                    <template v-for="list in userList">
                        <b-dropdown-item :key="list.id" @click="addPlaceToList(list.id)">{{ list.name }}
                        </b-dropdown-item>
                    </template>
                </b-dropdown>


                <b-dropdown>
                    <button class="button is-primary" slot="trigger">
                        <i class="far fa-share-square" />Share
                        <b-icon icon="menu-down" />
                    </button>

                    <b-dropdown-item has-link>
                        <a :href="'https://www.facebook.com/sharer/sharer.php?u=' + pageLink" target="_blank">
                            <i class="fab fa-facebook-square" />
                            Share on Facebook
                        </a>
                        <a :href="'http://twitter.com/share?text='+localizedName+'&hashtags=hedonist,binaryacademy&url=' + pageLink" target="_blank">
                            <i class="fab fa-twitter-square" />
                            Share on Twitter
                        </a>
                    </b-dropdown-item>
                </b-dropdown>
            </div>
        </div>
        <div class="place-top-info__sidebar columns">
            <div class="column is-two-third">
                <nav class="sidebar-actions tabs">
                    <ul>
                        <li
                            @click="changeTab(1)"
                            :class="{ 'is-active' : activeTab === 1}"
                        >
                            <a><span>Reviews ({{ getReviewsCount }})</span></a>
                        </li>
                        <li
                            @click="changeTab(2)"
                            :class="{ 'is-active' : activeTab === 2}"
                        >
                            <a><span>Photos ({{ photosCount }})</span></a>
                        </li>
                    </ul>
                </nav>
            </div>
            <div class="column is-one-third place-rate">
                <PlaceRating
                    v-if="place.rating"
                    :value="Number(place.rating)"
                    :show-max="true"
                />
                <div class="place-rate__mark-count">
                    {{ place.ratingCount || 'No' }} marks
                </div>
            </div>
        </div>
    </div>
</template>

<script>
import PlacePhotoList from './PlacePhotoList';
import PlaceCheckinModal from './PlaceCheckinModal';
import { STATUS_NONE } from '@/services/api/codes';
import defaultMarker from '@/assets/default_marker.png';
import { mapGetters } from 'vuex';
import PlaceRating from './PlaceRating';

export default {
    name: 'PlaceTopInfo',

    components: {
        PlacePhotoList,
        PlaceCheckinModal,
        PlaceRating,
    },

    props: {
        place: {
            type: Object,
            required: true
        }
    },

    filters: {
        formatRating: function (number) {
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
            userList: {},
            isCheckinModalActive: false
        };
    },

    created() {
        this.$store.dispatch('userList/getListsByUser', this.user.id)
            .then((result) => {
                this.userList = result;
            });

        this.$store.dispatch('place/getLikedPlace', this.place.id);
    },

    computed: {
        ...mapGetters('review', [ 'getReviewsCount' ]),

        user() {
            return this.$store.getters['auth/getAuthenticatedUser'];
        },

        localizedName() {
            return this.place.localization[0].name;
        },

        photosCount() {
            return this.place.photos.length;
        },

        liked() {
            return this.$store.getters['place/getLikedStatus'];
        },

        likes() {
            return this.$store.getters['place/getLikes'];
        },

        dislikes() {
            return this.$store.getters['place/getDislikes'];
        },
        
        pageLink() {
            return location.href;
        },

        placeMarker() {
            return defaultMarker;
        },
    },

    methods: {
        changeTab: function (activeTab) {
            this.activeTab = activeTab;
            this.$emit('tabChanged', activeTab);
        },

        updateLikesDislikes() {
            if (this.likes) {
                this.place.likes = this.likes;
            }
            if (this.dislikes) {
                this.place.dislikes = this.dislikes;
            }
        },

        like() {
            this.$store.dispatch('place/likePlace', this.place.id);
            this.updateLikesDislikes();
        },

        dislike() {
            this.$store.dispatch('place/dislikePlace', this.place.id);
            this.updateLikesDislikes();
        },

        addPlaceToList: function (listId) {
            this.$store.dispatch('userList/addPlaceToList', {
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
                display: flex;
                align-items: center;
                justify-content: center;
                &__mark-count {
                    font-style: italic;
                    white-space: nowrap;
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

    @media screen and (min-width: 769px) and (max-width: 1005px) {
        .place-top-info {
            &__sidebar {
                .place-rate {
                    &__mark-count{
                        display: none;
                    }
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
