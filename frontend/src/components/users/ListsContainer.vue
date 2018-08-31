<template>
    <div class="container user-cities">
        <h3 class="subtitle is-4">{{userProfile.first_name}} : favorite cities</h3>

        <ul class="columns is-variable is-4 is-multiline user-cities-items">

            <li class="column is-4">
                <div class="cities-cart"
                     style="background-image: url('https://igx.4sqi.net/img/general/340x300/56255921_ND28KNkEc3SDMx4yT-RRrX7Yo5oGYWEaCkCItehGros.jpg');">
                    <div>
                        <p><span class="cities-cart-name">Odesa</span></p>
                        <p><span class="cities-cart-reviews">42 reviews</span></p>
                    </div>
                    <div class="cities-cart-see">
                        <a href="#" class="button is-info">
                            <span>See all lists in this city</span>
                        </a>
                    </div>
                </div>

            </li>
            <li class="column is-4">
                <div class="cities-cart"
                     style="background-image: url('https://igx.4sqi.net/img/general/340x300/39381392_RNQBVEoRAFvuXjp7XeAIuNsAvUYo_mC68kffS-0OtLA.jpg');">
                    <div>
                        <p><span class="cities-cart-name">Odesa</span></p>
                        <p><span class="cities-cart-reviews">42 reviews</span></p>
                    </div>
                    <div class="cities-cart-see">
                        <a href="#" class="button is-info">
                            <span>See all lists in this city</span>
                        </a>
                    </div>
                </div>
            </li>
            <li class="column is-4">
                <div class="cities-cart"
                     style="background-image: url('https://igx.4sqi.net/img/general/340x300/34706843_1A6_hykGqxpMqduFANofMzzPssLIuHvpYGwm2zY8QLY.jpg');">
                    <div>
                        <p><span class="cities-cart-name">Kiev</span></p>
                        <p><span class="cities-cart-reviews">38 reviews</span></p>
                    </div>
                    <div class="cities-cart-see">
                        <a href="#" class="button is-info">
                            <span>See all lists in this city</span>
                        </a>
                    </div>
                </div>
            </li>
            <li class="column is-4">
                <div class="cities-cart"
                     style="background-image: url('https://igx.4sqi.net/img/general/340x300/139800814_QQO75Sr4LRtolXbmuOvmXPSz2HiFFmOTKeiMuJgumVs.jpg');">
                    <div>
                        <p><span class="cities-cart-name">Kiev</span></p>
                        <p><span class="cities-cart-reviews">38 reviews</span></p>
                    </div>
                    <div class="cities-cart-see">
                        <a href="#" class="button is-info">
                            <span>See all lists in this city</span>
                        </a>
                    </div>
                </div>
            </li>
        </ul>

    </div>
</template>

<script>
    import {mapState, mapActions, mapGetters} from 'vuex';
    export default {
        name: 'ListsContainer',
        data() {
            return {};
        },
        computed: {
            ...mapGetters({
                userProfile: 'users/getUserProfile'
            })
        },
    }
</script>

<style lang="scss" scoped>
    .user-cities {
        padding: 20px 0;
        h3 {
            text-align: center;
        }

        .user-cities-items {
            li {

                .cities-cart {
                    box-shadow: 0px 4px 4px 0px rgba(0,0,0,0.28);
                    display: flex;
                    flex-direction: column;
                    justify-content: space-between;
                    border-radius: 3px;
                    padding: 20px;
                    background-color: #fff;
                    height: 300px;
                    background-position: center;
                    background-size: cover;
                    background-repeat: no-repeat;
                    cursor: pointer;
                    transition: 0.3s linear;

                    &:hover{
                        box-shadow: 0px 4px 4px 0px rgba(0,0,0,0.5);
                    }

                    &-name,
                    &-reviews {
                        display: inline-block;
                        padding: 0 10px;
                        background-color: rgba(146, 146, 146, 0.74);
                        color: #ffffff;
                    }

                    &-name {
                        font-size: 26px;
                        margin-bottom: 5px;
                    }
                    &-reviews {
                        font-size: 18px;
                    }

                    &-see {
                        a {
                            display: block;
                        }

                    }
                }
            }
        }
    }
</style>