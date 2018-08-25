<template>
    <aside class="column is-one-third">
        <div class="place-sidebar">
            <div class="map-box">
                <PlaceMapMarker :place="place" />
            </div>
            <div class="place-sidebar__info">
                <div class="place-sidebar__venue">
                    <i class="place-sidebar__icon far fa-compass" />
                    <div v-if="place.localization" class="place-name"><strong>{{ place.localization.name }}</strong></div>
                    <div v-else class="place-name"><strong>No localization</strong></div>
                    <div class="place-address">
                        <span class="place-street">{{ place.address }}</span>,
                        <span class="place-city">{{ place.city.name }}</span>,
                        <span class="place-zip">{{ place.zip }}</span>,
                        <span class="place-country">Украина</span>
                    </div>
                </div>
                <div v-if="place.category.tags" class="place-sidebar__tags">
                    <i class="place-sidebar__icon fas fa-info-circle" />
                    <span 
                        v-for="tag in place.category.tags"
                        class="tag"
                        :key="tag.id"
                    >
                        {{ tag.name }}
                    </span>
                </div>
                <div class="place-sidebar__worktime">
                    <i class="place-sidebar__icon far fa-clock" />
                    <span class="worktime-info--red">Закрыто до 15:00</span>
                </div>
                <div class="place-sidebar__phone">
                    <i class="place-sidebar__icon fas fa-phone" />
                    <a 
                        class="phone-number" 
                        :href="`tel:${place.phone}`"
                    >
                        {{ place.phone }}
                    </a>
                </div>
                <div v-if="place.website" class="place-sidebar__website">
                    <i class="place-sidebar__icon fas fa-globe" />
                    <a
                        target="_blank"
                        :href="place.website"
                    >
                        {{ place.website }}
                    </a>
                </div>
                <template v-if="place.placeInfo">
                    <div class="place-sidebar__facebook" v-if="place.placeInfo.facebook">
                        <i class="place-sidebar__icon fab fa-facebook-square" />
                        <a :href="place.placeInfo.facebook">{{ place.placeInfo.facebook }}</a>
                    </div>
                    <div class="place-sidebar__facebook" v-if="place.placeInfo.instagram">
                        <i class="place-sidebar__icon fab fa-instagram" />
                        <a :href="place.placeInfo.instagram">{{ place.placeInfo.instagram }}</a>
                    </div>
                </template>
            </div>
            <template v-if="place.features.length > 0">
                <div class="place-sidebar__features">
                    <h2 class="feature-title">Features</h2>
                    <div
                        v-for="feature in place.features"
                        :key="feature.id"
                        class="place-sidebar__feature-list"
                    >
                        <div class="feature">
                            <div class="feature-name">{{ feature.name }}</div>
                            <div class="feature-info"><i class="fas fa-check" /></div>
                        </div>
                    </div>
                </div>
            </template>
        </div>
    </aside>
</template>

<script>
import PlaceMapMarker from './PlaceMapMarker';

export default {
    name: 'PlaceSidebarInfo',

    components: {
        PlaceMapMarker
    },

    props: {
        place: {
            type: Object,
            required: true
        }
    }
};
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

    &__tags {
        line-height: 30px;

        .tag {
            margin-right: 5px;
            color: white;
            background-color: #167df0;
            cursor: pointer;
        }
    }
}

</style>
