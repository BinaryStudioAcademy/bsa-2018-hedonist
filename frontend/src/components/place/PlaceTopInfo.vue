<template>
    <div class="place-top-info">
        <PlacePhotoList :photos="photos" @showAllPhotos="changeTab(2)" />
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
                <TopInfoUserListItem
                    :place="place"
                    :lists="userList"
                />
                <ShareDropdown
                    :link="pageLink"
                    :text="localizedName"
                />
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
                            <a><span>Reviews ({{ this.getTotalReviewCount(this.place.id) }})</span></a>
                        </li>
                        <li
                            @click="changeTab(2)"
                            :class="{ 'is-active' : activeTab === 2}"
                        >
                            <a><span>Photos <template v-if="loaded">({{ photosCount }})</template></span></a>
                        </li>
                    </ul>
                </nav>
            </div>
            <div class="column is-one-third place-rate">
                <PlaceRating
                    v-if="place.rating"
                    :value="Number(place.rating)"
                    :show-max="true"
                    :show-rating="true"
                    :rating-count="place.ratingCount"
                />

                <span class="v-badge v-badge--overlap">
                    <div
                        class="button is-primary rating"
                        @click="toggleIsUsersListModalActive"
                    >
                        <i class="fas fa-eye" />
                    </div>
                    <span
                        v-if="visitors.allIds.length > 1"
                        class="v-badge__badge orange"
                    >
                        <span>
                            {{ visitors.allIds.length }}
                        </span>
                    </span>
                </span>
                <b-modal
                    :active.sync="isUsersListModalActive"
                    has-modal-card
                >
                    <UsersListModal
                        :users="visitors"
                        title="They look this page"
                        @close="toggleIsUsersListModalActive"
                    />
                </b-modal>

                <button
                    class="button is-primary rating"
                    @click="isCheckinModalActive = true"
                >
                    <i class="fas fa-star-half-alt" />
                </button>
                <b-modal :active.sync="isCheckinModalActive" has-modal-card>
                    <PlaceRatingModal :place="place" />
                </b-modal>

                <PlaceCheckin :place="place" />
            </div>
        </div>
    </div>
</template>

<script>
import PlacePhotoList from './PlacePhotoList';
import PlaceRatingModal from './PlaceRatingModal';
import UsersListModal from './UsersListModal';
import {STATUS_NONE} from '@/services/api/codes';
import defaultMarker from '@/assets/default_marker.png';
import {mapGetters, mapState} from 'vuex';
import PlaceRating from './PlaceRating';
import PlaceCheckin from './PlaceCheckin';
import ShareDropdown from '@/components/misc/ShareDropdown';
import TopInfoUserListItem from './TopInfoUserListItem';

export default {
    name: 'PlaceTopInfo',

    components: {
        PlacePhotoList,
        UsersListModal,
        PlaceRatingModal,
        PlaceRating,
        PlaceCheckin,
        ShareDropdown,
        TopInfoUserListItem
    },

    props: {
        place: {
            type: Object,
            required: true
        },
        isLoadingReviewPhoto: {
            type: Boolean,
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
            isUsersListModalActive: false,
            isCheckinModalActive: false
        };
    },

    created() {
        this.$store.dispatch('userList/getListsByUser', this.user.id);
        this.$store.dispatch('place/getLikedPlace', this.place.id);
    },

    computed: {
        ...mapGetters('review', ['getTotalReviewCount', 'getPlaceReviewPhotos']),
        ...mapState('userList', ['userLists']),
        ...mapState('place', ['visitors']),

        user() {
            return this.$store.getters['auth/getAuthenticatedUser'];
        },

        localizedName() {
            return this.place.localization[0].name;
        },

        photosCount() {
            return this.place.photos.length + this.getPlaceReviewPhotos.length;
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

        userList() {
            return this.userLists ? Object.values(this.userLists.byId) : [];
        },

        loaded() {
            return !(this.isLoadingReviewPhoto) && !!(this.getPlaceReviewPhotos);
        },

        photos() {
            let placePhotos = Object.values(this.place.photos);
            let placeReviewPhotos = Object.values(this.getPlaceReviewPhotos);
            return placePhotos.concat(placeReviewPhotos);
        }
    },

    methods: {
        toggleIsUsersListModalActive: function () {
            if (this.isUsersListModalActive || this.visitors.allIds.length > 1){
                this.isUsersListModalActive = !this.isUsersListModalActive;
            }
        },
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
                placeId: this.place.id,
                userId: this.user.id
            });
        },
    }
};
</script>

<style lang="scss" scoped>
    .place-top-info {
        background-color: #fff;
        .column {
            padding: 0.75rem;
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
                justify-content: space-around;
                align-items: center;
                &__mark-count {
                    font-style: italic;
                    white-space: nowrap;
                    margin-left: 20px;
                }
            }
        }
    }

    .rating {
        border-radius: 7px;
        height: 48px;
        width: 48px;
        font-size: 1.5rem;
        color: #FFF;
        text-align: center;
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
                    &__mark-count {
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

    .v-badge {
        display: inline-block;
        position: relative;
    }

    .v-badge--overlap .v-badge__badge {
        right: -8px;
        top: -8px;
    }
    .v-badge__badge {
        align-items: center;
        border-radius: 50%;
        color: #fff;
        display: flex;
        flex-direction: row;
        flex-wrap: wrap;
        font-size: 14px;
        height: 22px;
        justify-content: center;
        position: absolute;
        right: -22px;
        top: -11px;
        transition: .3s cubic-bezier(.25,.8,.5,1);
        width: 22px;
        z-index: 5;
    }
    .orange {
        background-color: #ff9800!important;
        border-color: #ff9800!important;
    }
    span {
        font-style: inherit;
        font-weight: inherit;
    }

</style>
