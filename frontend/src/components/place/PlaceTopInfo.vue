<template>
    <div class="place-top-info">
        <PlacePhotoList />
        <div class="place-venue columns">
            <div class="column is-three-fifths">
                <div class="place-venue__logo">
                    <img src="https://ss3.4sqi.net/img/categories_v2/food/caucasian_88.png" data-retina-url="https://ss3.4sqi.net/img/categories_v2/food/caucasian_512.png" width="88" height="88">
                </div>
                <div class="place-venue__prime-info">
                    <div class="place-venue__place-name">МАМА МАНАНА</div>
                    <div class="place-venue__category">Ресторан кавказской кухни</div>
                    <div class="place-venue__region">Голосеевский район, Киев</div>
                </div>
            </div>
            <div class="column is-two-fifths place-venue__actions">
                <button class="button is-success">
                    <i class="far fa-save"></i>Save
                </button>
                <button class="button is-info">
                    <i class="far fa-share-square"></i>Share
                </button>
            </div>
        </div>
        <div class="place-top-info__sidebar columns">
            <div class="column is-three-fifths">
                <b-tabs class="sidebar-actions" v-model="activeTab">
                    <b-tab-item label="Comments (123)"></b-tab-item>
                    <b-tab-item label="Photos (321)"></b-tab-item>
                </b-tabs>
            </div>
            <div class="column is-two-fifths place-rate">
                <div class="place-rate__mark">
                    <span>9.2</span><sup>/<span>10</span></sup>
                </div>
                <div class="place-rate__mark-count">444 marks</div>
                <div class="place-rate__preference">
                    <div class="likable like">
                       <span class="fa-stack fa-2x">
                            <i class="fa fa-heart fa-stack-1x"></i>
                        </span>
                    </div>
                    <div class="likable dislike">
                         <span class="fa-stack fa-2x">
                            <i class="fa fa-heart fa-stack-1x"></i>
                            <i class="fa fa-bolt fa-stack-1x fa-inverse"></i>
                        </span>
                    </div>
                </div>
            </div>
        </div>
    </div>
</template>

<script>
import PlacePhotoList from './PlacePhotoList';

export default {
    name: "PlaceTopInfo",
    components: {
        PlacePhotoList,
    },
    data() {
        return {
            activeTab: 0
        }
    }
}
</script>

<style lang="scss">
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
</style>