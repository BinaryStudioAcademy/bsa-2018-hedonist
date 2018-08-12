<template>
    <aside class="column is-one-third">
        <div class="place-sidebar">
            <div class="map-box">
                <img src="https://image.ibb.co/isC2MU/Screenshot_from_2018_08_09_00_25_38.png" alt="mapbox">
            </div>
            <div class="place-sidebar__info">
                <div class="place-sidebar__venue">
                    <i class="place-sidebar__icon far fa-compass"></i>
                    <div class="place-name"><strong>{{ place.name }}</strong></div>
                    <div class="place-address">
                        <div class="place-address">{{ place.address }}</div>
                        <span class="place-city">{{ place.city }}</span>,
                        <span class="place-zip">01004</span>
                    </div>
                </div>
                <div class="place-sidebar__tags">
                    <i class="place-sidebar__icon fas fa-info-circle"></i>
                    <span v-for="tag in place.tags" class="tag">{{ tag.name }}</span>
                </div>
                <div class="place-sidebar__worktime">
                    <i class="place-sidebar__icon far fa-clock"></i>
                    <span class="worktime-info--red">Закрыто до 15:00</span>
                </div>
                <div class="place-sidebar__phone">
                    <i class="place-sidebar__icon fas fa-phone"></i>
                    <a class="phone-number" :href="`tel:${place.phone}`">{{ place.phone }}</a>
                </div>
                <div class="place-sidebar__website">
                    <i class="place-sidebar__icon fas fa-globe"></i>
                    <a target="_blank" :href="place.website">{{ place.website }}</a>
                </div>
                <div class="place-sidebar__facebook">
                    <i class="place-sidebar__icon fab fa-facebook-square"></i>
                    <a href="https://www.facebook.com/mamamanana.kiev">mamamanana.kiev</a>
                </div>
                <div class="place-sidebar__facebook">
                    <i class="place-sidebar__icon fab fa-instagram"></i>
                    <a href="https://www.instagram.com/mamamanana.kiev.ua/">@mamamanana.kiev.ua</a>
                </div>
            </div>
            <div class="place-sidebar__features">
                <h2 class="feature-title">Features</h2>
                <div class="feature">
                    <div class="feature-name">Бронирование</div>
                    <div class="feature-info"><i class="fas fa-check"></i></div>
                </div>
                <div class="feature">
                    <div class="feature-name">Кредитные карты</div>
                    <div class="feature-info"><i class="fas fa-check"></i></div>
                </div>
                <div class="feature">
                    <div class="feature-name">WiFi</div>
                    <div class="feature-info"><i class="fas fa-check"></i></div>
                </div>
                <div class="feature">
                    <div class="feature-name">Есть заезд для инвалидных колясок</div>
                    <div class="feature-info"><i class="fas fa-check"></i></div>
                </div>
                <div class="feature">
                    <div class="feature-name">Музыка</div>
                    <div class="feature-info"><i class="fas fa-check"></i></div>
                </div>
                <div class="feature">
                    <div class="feature-name">Варианты обеда</div>
                    <div class="feature-info"><i class="fas fa-check"></i></div>
                </div>
                <div class="feature">
                    <div class="feature-name">Есть туалет</div>
                    <div class="feature-info"><i class="fas fa-check"></i></div>
                </div>
            </div>
        </div>
    </aside>
</template>

<script>
export default {
    name: "PlaceSidebarInfo",
    props: {
        place: {
            type: Object,
            required: true
        }
    },
}
</script>

<style lang="scss" scoped>

.place-sidebar {
    background-color: #fff;

    .map-box {
        padding: 10px;

        img {
            width: 100%;
        }
    }

    &__info {
        > div {
            margin: 15px 25px 15px 50px;
            position: relative;
            padding-bottom: 10px;
            border-bottom: 1px solid lightgray;

            &:last-child {
                border: none;
            }
        }
    }

    &__icon {
        position: absolute;
        top: 5px;
        left: -25px;
    }

    &__worktime {

        .worktime-info {
            &--red {
                color: red;
            }
        }
    }
    
    &__features {
        .feature-title {
            font-weight: bold;
            padding: 20px;
            background-color: #f7f7fa;
            border-bottom: 1px solid #efeff4;
            border-top: 1px solid #efeff4;
        }

        .feature {
            display: flex;
            flex-direction: row;
            justify-content: space-between;
            padding: 10px 20px;
            border-bottom: 1px solid #efeff4;

            .feature-name {
                flex: 80%;
            }

            .feature-info {
                flex: 20%;
                text-align: right;
                color: greenyellow;
            }
        }
    }
}

</style>