<template>
    <div class="container is-fullhd">
        <div class="container">

            <div class="columns user-info">

                <div class="column is-narrow user-info-img">
                    <figure class="image is-128x128">
                        <img src="https://igx.4sqi.net/img/user/130x130/63127607-FUGH5AYFXN0RRZWT.jpg" alt="">
                    </figure>
                </div>

                <div class="column user-info-stats">

                    <div class="user-stats-title">
                        <h1 class="subtitle is-3">Valeri</h1>
                        <a href="#" class="facebbok-link" target="_blank">
                            <i class="fa-2x fab fa-facebook-square"></i>
                        </a>
                        <a href="#" class="twitter-link" target="_blank">
                            <i class="fa-2x fab fa-twitter-square"></i>
                        </a>
                    </div>

                    <div class="user-stats-contact">
                        <h6 class="subtitle is-7">Odessa</h6>
                    </div>

                    <div class="user-stats-complaint">
                        <span class="">Пожаловаться на этого человека?</span>
                    </div>
                </div>

                <div class="column user-info-relation">

                    <ul class="level">
                        <li class="level-item has-text-centered">
                            <div>
                                <p class="relation-count">20</p>
                                <p class="relation-title">Reviews</p>
                            </div>
                        </li>
                        <li class="level-item has-text-centered">
                            <div>
                                <p class="relation-count">105</p>
                                <p class="relation-title">Followers</p>

                            </div>
                        </li>
                        <li class="level-item has-text-centered">
                            <div>
                                <p class="relation-count">350</p>
                                <p class="relation-title">Following</p>
                            </div>
                        </li>
                        <li class="level-item has-text-centered">
                            <div>
                                <p class="relation-count">3</p>
                                <p class="relation-title">Lists</p>
                            </div>
                        </li>
                    </ul>

                    <a class="button is-success">
                            <span class="icon is-small">
                              <i class="fas fa-check"></i>
                            </span>
                        <span>Save</span>
                    </a>

                </div>
            </div>

        </div>
    </div>
</template>

<script>
    export default {
        name: 'GeneralInfo',
    };
</script>

<style lang="scss" scoped>

    .is-fullhd {
        margin: 10px 0;
        padding: 20px 0;
        background-color: #fff;
    }

    .user-info {

        &-img {
            img {
                border-radius: 32px;
            }

        }

        &-stats {

            .user-stats-title {
                h1 {
                    display: inline-block;
                    margin-right: 15px;
                    margin-bottom: 0;
                }
                a {
                    display: inline-block;
                    transition: 0.3s linear;
                    &:hover {
                        color: #5a5866;
                    }
                }
                .facebbok-link {
                    color: #4E71A8;
                    margin-right: 7px;
                }

                .twitter-link {
                    color: #1CB6EA;
                }
            }

            .user-stats-complaint {
                span {
                    font-size: 11px;
                    color: #aeb4b6;
                    cursor: pointer;

                    &:hover {
                        text-decoration: underline;
                    }
                }
            }



        }

        &-relation{
            padding: 0;
            align-self: end;
            .level{
                margin-bottom: 10px;
                li{
                    border-right: 1px solid rgba(199,205,207,0.3);

                    &:nth-last-child(1){
                        border-right: none;
                    }
                }

            }
            .relation-count{
                font-weight: bold;
                font-size: 20px;
            }
            .relation-title{
                font-size: 12px;
                color: #aeb4b6;
            }
        }
    }
</style>