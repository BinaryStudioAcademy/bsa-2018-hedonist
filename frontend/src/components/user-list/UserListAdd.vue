<template>
    <div class="container">
        <div class="left-block">
            <div class="list-edit-details">
                <div class="name-desc-section">
                    <input type="text" class="text">
                </div>
                <div class="photo-section">
                    <div>
                        <img class="list-page-image" src="" alt="">
                    </div>
                    <div class="selector-button flatButton">Photo ▾</div>
                </div>
                <div class="buttons">
                    <button class="button-green">Save</button>
                    <span class="button-link">Cancel</span>
                </div>
            </div>
            <div class="search-places">
                <input type="text" class="search-field" v-on:keyup="keyUp">
                <ul class="search-places__list" v-show="displayList">
                    <li>
                        <a href="#">
                            <img height="32" width="32" class="search-places__list__img"
                                 src="https://ss3.4sqi.net/img/categories_v2/arts_entertainment/stadium_baseball_bg_32.png"
                                 alt="place image">
                            <div class="search-places__list__details">
                                <div class="search-places__list__name">Yankee Stadium</div>
                                <div class="search-places__list__description">1 E 161st St (btwn Jerome & Rivera Ave)
                                </div>
                            </div>
                        </a>
                    </li>
                    <li>
                        <a href="#">
                            <img height="32" width="32" class="search-places__list__img"
                                 src="https://ss3.4sqi.net/img/categories_v2/arts_entertainment/stadium_baseball_bg_32.png"
                                 alt="place image">
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
        <div class="right-block"></div>
    </div>
</template>

<script>
    export default {
        name: "UserListAdd",
        data: function () {
            return {
                displayList: false
            }
        },
        methods: {
            keyUp() {
                this.displayList = true;
            }
        }
        // created: function() {
        //     let self = this;
        //     let list = self.$el.querySelector('.search-places__list');
        //
        //     window.addEventListener('click', function(e){
        //         if (!list.$el.contains(e.target)){
        //             self.displayList = false
        //         }
        //     })
        // }
    }
</script>

<style lang="scss" scoped>
    .container {
        border-radius: 3px;
        background: #fff;
        position: relative;
        display: grid;
        grid-template-columns: repeat(3, 1fr);
        grid-template-areas: "left left right";
    }

    .left-block {
        grid-area: left;
        display: flex;
        flex-direction: column;

        .list-edit-details {
            padding: 20px;
            display: flex;
            flex-direction: column;

            .photo-section {
                height: 118px;
                width: 118px;
                position: relative;

                border-radius: 3px;
                background: #f5f5f5 url(../../assets/no-photo.png) no-repeat center 40px;
                background-position: center 25px;
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

            .buttons {
                margin-top: 10px;
            }
        }

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

    .right-block {
        grid-area: right;
        background-color: #fcfcfc;
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
        width: 450px;
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

    .button-link {
        color: #2d5be3;
        cursor: pointer;
        font-size: 0.9rem;
    }


</style>