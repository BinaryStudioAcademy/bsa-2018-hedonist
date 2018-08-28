<template>
    <div class="container">
        <div class="top-left">
            <div class="photo-section">
                <div>
                    <img
                        class="list-page-image"
                        src=""
                        alt=""
                    >
                </div>
                <div class="selector-button flatButton">Photo ▾</div>
            </div>
            <div class="name-desc-section">
                <input
                    type="text"
                    class="text"
                >
            </div>
        </div>
        <div class="top-right">
            <button class="button-green">Save</button>
            <button class="button-grey">Delete</button>
        </div>
        <div class="bottom-left">
            <div class="search-places">
                <input
                    placeholder="Search places"
                    type="text"
                    class="search-field"
                    @keyup="keyUp"
                >
                <ul
                    class="search-places__list"
                    v-show="displayList"
                    v-click-outside="onClickOutside"
                >
                    <li>
                        <a href="#">
                            <img
                                height="32"
                                width="32"
                                class="search-places__list__img"
                                src="https://ss3.4sqi.net/img/categories_v2/arts_entertainment/stadium_baseball_bg_32.png"
                                alt="place image"
                            >
                            <div class="search-places__list__details">
                                <div class="search-places__list__name">Yankee Stadium</div>
                                <div class="search-places__list__description">1 E 161st St (btwn Jerome & Rivera Ave)
                                </div>
                            </div>
                        </a>
                    </li>
                    <li>
                        <a href="#">
                            <img
                                height="32"
                                width="32"
                                class="search-places__list__img"
                                src="https://ss3.4sqi.net/img/categories_v2/arts_entertainment/stadium_baseball_bg_32.png"
                                alt="place image"
                            >
                            <div class="search-places__list__details">
                                <div class="search-places__list__name">Yankee Stadium</div>
                                <div class="search-places__list__description">1 E 161st St (btwn Jerome & Rivera Ave)
                                </div>
                            </div>
                        </a>
                    </li>
                </ul>
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
                />
            </div>
        </div>
    </div>
</template>

<script>
import Mapbox from 'mapbox-gl-vue';
import mapSettingsService from '@/services/map/mapSettingsService';

export default {
    name: 'UserListAdd',
    components: {
        Mapbox
    },
    data: function () {
        return {
            displayList: false,
            mapboxToken: mapSettingsService.getMapboxToken(),
            mapboxStyle: mapSettingsService.getMapboxStyle()
        };
    },
    methods: {
        keyUp() {
            this.displayList = true;
        },
        onClickOutside() {
            this.displayList = false;
        }
    }
};
</script>

<style lang="scss" scoped>
    .container {
        border-radius: 3px;
        background: #fff;
        position: relative;
        display: grid;
        grid-template-areas: "top-left top-left top-right" "bottom-left bottom-left bottom-right";
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
            width: 83%;
        }
    }

    .top-right {
        grid-area: top-right;
        border-left: 1px solid #e8e9eb;
        background-color: #f0f4f5;
        display: flex;
        justify-content: center;
        align-items: center;
    }

    .bottom-left {
        grid-area: bottom-left;

        .search-places {
            background: #f0f4f5;
            border-bottom: 1px solid #dae4e6;
            border-top: 1px solid #dae4e6;
            overflow: visible;
            padding: 20px;
            position: relative;

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

            &__list {
                z-index: 999999;
                left: 20px;
                position: absolute;
                top: 64px !important;
                width: 430px;
                background: #fff;
                border: 1px solid #3990bb;
                border-top: none !important;
                box-shadow: rgba(0, 0, 0, 0.1) 0 0 2px 0;
                border-radius: 0 0 5px 5px;
                vertical-align: baseline;

                li {
                    line-height: 16px;
                    margin: 0;
                    overflow: hidden;
                    padding: 0;
                    white-space: nowrap;

                    a {
                        background: #fff;
                        cursor: pointer;
                        display: flex;
                        padding: 5px 10px;
                        text-decoration: none;
                        zoom: 1;
                    }
                    a:hover {
                        background: #f5f5f5;
                    }
                }

                &__details {
                    display: flex;
                    flex-direction: column;
                    margin-left: 5px;
                }

                &__name {
                    color: #333;
                    font-weight: bold;
                    overflow: hidden;
                    text-overflow: ellipsis;
                    font-size: 0.9rem;
                }
                a:hover .search-places__list__name {
                    color: #2d5be3;
                }

                &__description {
                    color: #999;
                    font-weight: normal;
                    overflow: hidden;
                    text-overflow: ellipsis;
                    font-size: 0.9rem;
                }
            }
        }
    }

    .bottom-right {
        grid-area: bottom-right;
        border-left: 1px solid #e8e9eb;
        border-top: 1px solid #e8e9eb;

        .mapbox-wrapper {
            position: relative;
            height: 320px;

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

    .button-green {
        letter-spacing: 0;
        box-sizing: border-box;
        box-shadow: none;
        text-shadow: none;
        border-radius: 3px;
        background: #00b551;
        border: 1px solid rgba(0, 0, 0, 0.05);
        color: #fff;
        cursor: pointer;
        display: block;
        font-size: 0.9rem;
        height: 30px;
        line-height: 28px;
        padding: 0 30px;
        text-align: center;
        text-transform: none;
        margin-right: 15px;
    }

    .button-green:hover {
        background: #4ca958;
    }

    .button-grey {
        border-radius: 3px;
        background: #efeff4;
        border: 1px solid rgba(0, 0, 0, 0.05);
        color: #4e595d;
        cursor: pointer;
        display: block;
        font-size: 0.9rem;
        font-weight: normal;
        height: 30px;
        line-height: 28px;
        padding: 0 10px;
        text-align: center;
        text-transform: none;
    }

    .button-grey:hover {
        background: rgb(227, 227, 232);
        color: rgb(78, 89, 93);
        border-width: 1px;
        border-style: solid;
        border-color: rgba(0, 0, 0, 0);
    }

    @media screen and (max-width: 769px) {
        .container {
            grid-template-areas: "top-left" "top-right" "bottom-left" "bottom-right";
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

                .name-desc-section {
                    width: auto;
                }
            }
        }

    }
</style>