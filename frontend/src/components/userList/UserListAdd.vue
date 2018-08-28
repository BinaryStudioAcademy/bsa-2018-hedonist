<template>
    <div class="container">
        <Preloader :active="isLoading" />
        <form
            class="form"
            @submit.prevent
            novalidate="true"
        >
            <div class="top-left">
                <div class="image-upload">
                    <div class="image-wrapper">
                        <img class="place-image" :src="imagePreview || imageStub">
                    </div>
                    <div class="field">
                        <div class="file is-primary">
                            <label class="file-label width100">
                                <input
                                    @change="previewImage"
                                    class="file-input"
                                    type="file"
                                    name="photo"
                                >
                                <span class="file-cta width100">
                                    <span class="file-icon">
                                        <i class="fas fa-upload" />
                                    </span>
                                    <span class="file-label">
                                        Load a preview
                                    </span>
                                </span>
                            </label>
                        </div>
                    </div>
                </div>
                <div class="name-desc-section width100">
                    <label class="label" for="list-name">List name</label>
                    <input
                        v-model="userList.name"
                        id="list-name"
                        type="text"
                        class="text"
                        name="name"
                    >
                    <div class="top-right">
                        <button class="button is-success" @click="onSave">Save</button>
                    </div>
                </div>
            </div>
        </form>
        <div class="bottom-left">
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
        <div class="bottom-right">
            <div class="mapbox-wrapper">
                <mapbox
                    :access-token="mapboxToken"
                    :map-options="{
                        style: mapboxStyle,
                        center: {
                            lat: 50.4547,
                            lng: 30.5238
                        },
                        zoom: 9
                    }"
                    :scale-control="{
                        show: true,
                        position: 'top-left'
                    }"
                    @map-init="mapInitialize"
                />
            </div>
        </div>
        <back-to-top>
            <button type="button" class="btn btn-info btn-to-top">
                <i class="fa fa-chevron-up" />
            </button>
        </back-to-top>
    </div>
</template>

<script>
import { mapActions } from 'vuex';
import Preloader from '@/components/misc/Preloader';
import Mapbox from 'mapbox-gl-vue';
import markerManager from '@/services/map/markerManager';
import imageStub from '@/assets/no-photo.png';
import mapSettingsService from '@/services/map/mapSettingsService';
import { required } from 'vuelidate/lib/validators';
import BackToTop from 'vue-backtotop';

export default {
    name: 'UserListAdd',
    components: {
        Mapbox,
        Preloader,
        BackToTop
    },
    data: function () {
        return {
            displayList: false,
            isLoading: false,
            mapboxToken: mapSettingsService.getMapboxToken(),
            mapboxStyle: mapSettingsService.getMapboxStyle(),
            userList: {
                name: null,
                image: null
            },
            searchName: '',
            placesLocation: '30.5241,50.4501',
            imagePreview: null,
            isPlaceFetching: false,
            markerManager: null,
            errors: null,
            places: [],
            attachedPlaces: [],
            imageStub: imageStub,
            availableImageTypes: [
                'image/jpeg',
                'image/jpg',
                'image/png',
            ]
        };
    },
    watch: {
        'attachedPlaces': function() {
            this.markerManager.setMarkersFromPlacesAndFit(...this.attachedPlaces);
        }
    },
    computed: {
        searchInputLoadingClass() {
            return this.isPlaceFetching ? 'is-loading' : false;
        }
    },
    methods: {
        ...mapActions({
            save: 'userList/saveUserLists',
            fetchPlaces: 'place/fetchPlaces'
        }),

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
        onSave () {
            this.isLoading = true;
            if (this.$v.userList.$invalid) {
                this.onError('Photo and name are required!');
                this.isLoading = false;
                return;
            }

            this.save({
                userList: this.userList,
                attachedPlaceIds: this.attachedPlaces.map((place) => place.id)
            })
                .then(() => {
                    this.isLoading = false;
                    this.onSuccess({ message: 'The list was saved!' });
                    this.$router.push({ name: 'UserListsPage' });
                })
                .catch((err) => {
                    this.isLoading = false;
                    this.onError(err.response.data);
                });
        },
        onError (message = 'Error occurred') {
            this.$toast.open({
                message: message,
                type: 'is-danger'
            });
        },
        onSuccess (success) {
            this.$toast.open({
                message: success.message,
                type: 'is-success'
            });
        },
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
        previewImage: function(event) {
            const file = event.target.files[0];
            const reader = new FileReader();
            this.userList.image = null;
            if (file) {
                reader.onload = (e) => {
                    if (this.checkFileType(file.type)) {
                        this.imagePreview = e.target.result;
                        this.userList.image = file;
                    }
                };

                reader.readAsDataURL(file);
            }
        },
        checkFileType(fileType) {
            return this.availableImageTypes.includes(fileType);
        },
        mapInitialize(map) {
            this.markerManager = markerManager.getService(map);
        }
    },
    validations: {
        userList: {
            name: {
                required,
            },
            image: {
                required,
            },
        }
    }
};
</script>

<style lang="scss" scoped>
    .width100 {
        width: 100%;
    }

    .control.is-loading::after {
        right: 1.625em;
        top: 30px;
    }

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

    .btn-to-top {
        display: none;
        width: 60px;
        height: 60px;
        padding: 10px 16px;
        border-radius: 50%;
        font-size: 22px;
        line-height: 22px;
    }

    .place-image {
        border-radius: 5px;
        width: 100%;
        height: 100%;
        object-fit: cover;
        object-position: 50% 50%;
    }

    .form {
        grid-area: form;
        position: sticky;
        top: 50px;
        z-index: 2;
        background-color: #fff;
    }

    .image-wrapper {
        width: 180px;
        height: 128px;
        overflow: hidden;
        margin-bottom: 10px;
    }

    .container {
        border-radius: 3px;
        background: #fff;
        position: relative;
        display: grid;
        grid-template-columns: 1.2fr 0.8fr;
        grid-template-rows: 214px auto;
        grid-template-areas: "form bottom-right" "bottom-left bottom-right";
        margin-top: 40px;
    }

    .top-left {
        grid-area: top-left;
        padding: 20px;
        display: flex;
        align-items: center;

        .photo-section {
            height: 118px;
            width: 118px;
            position: relative;

            border-radius: 3px;
            background: #f5f5f5 url(../../assets/no-photo.png) no-repeat center 40px;
            background-position: center 25px;
            margin-right: 20px;
        }

        .selector-button {
            bottom: 0;
            margin: 11px;
            width: 96px;
            position: absolute;

            border-radius: 3px;
            background: #4d4d4d;
            background: rgba(0, 0, 0, 0.2);
            color: #fff;
            cursor: pointer;
            font: bold 11px/30px "Helvetica Neue", Helvetica, Arial, sans-serif;
            line-height: 20px;
            text-align: center;
            text-transform: uppercase;
        }

        .name-desc-section {
            margin-left: 30px;
        }
    }

    .top-right {
        grid-area: top-right;
        display: flex;
        justify-content: center;
        align-items: center;
    }

    .bottom-left {
        grid-area: bottom-left;

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

    .bottom-right {
        grid-area: bottom-right;
        border-left: 1px solid #e8e9eb;
        border-top: 1px solid #e8e9eb;
        position: relative;

        .mapbox-wrapper {
            position: sticky;
            top: 50px;
            height: calc(100vh - 50px);

            #map {
                text-align: justify;
                position: absolute;
                top: 0;
                bottom: 0;
                right: 0;
                width: 100%;
            }
        }
    }

    .text {
        font-size: 2rem;
        font-weight: bold;
        line-height: 120%;
        padding: 6px 7px 5px 5px;

        transition-duration: .33s;
        transition-property: background, border, color, opacity, box-shadow;
        -moz-border-radius: 3px;
        -webkit-border-radius: 3px;
        border-radius: 3px;
        color: #4e595d;
        letter-spacing: 0;
        -webkit-font-smoothing: antialiased;
        background: #fff;
        border: 1px solid #c7cdcf;
        outline: none;
        margin: 0 0 10px 0;
        width: 100%;
    }

    @media screen and (max-width: 769px) {
        .container {
            grid-template-areas: "form" "bottom-right" "bottom-left";
            grid-template-columns: auto;
            grid-template-rows: auto;
        }

        .form {
            position: relative;
        }

        .btn-to-top {
            display: block;
        }

        .bottom-left {
            .search-places {
                position: relative;
                top: 0;
            }
        }
    }

    @media screen and (max-width: 520px) {
        .container {
            .top-left {
                flex-direction: column;
                align-items: center;

                .photo-section {
                    margin: 0 0 20px 0;
                }
            }
        }

    }
</style>