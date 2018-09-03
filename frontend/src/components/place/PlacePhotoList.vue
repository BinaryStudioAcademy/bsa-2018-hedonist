<template>
    <div class="photo-slider">
        <span class="photo-slider__left-arrow slider-arrow">
            <i @click="toLeft" class="fas fa-caret-left" />
        </span>
        <ul
            ref="photo-list"
            class="photo-slider__list"
        >
            <li
                v-for="(photo, i) in photos.slice(0, maxImages)"
                :key="photo.id"
            >
                <PlacePhoto
                    :key="photo.id"
                    :photo="photo"
                    :last-photo="(i + 1) === maxImages && photos.length > maxImages"
                    @showAllPhotos="showAllPhotos"
                />
            </li>
        </ul>
        <span class="photo-slider__right-arrow slider-arrow">
            <i @click="toRight" class="fas fa-caret-right" />
        </span>
    </div>
</template>

<script>
import PlacePhoto from './PlacePhoto';

export default {
    name: 'PlacePhotoList',
    components: { PlacePhoto },
    props: {
        photos: {
            type: Array,
            required: true
        }
    },
    data() {
        return {
            photoList: null,
            imageOffset: null,
            imageSlideNumber: 2,
            maxImages: 11
        };
    },
    mounted() {
        this.photoList = this.$refs['photo-list'];
        this.imageOffset = this.photoList.childNodes[0].offsetWidth;
    },
    methods: {
        toRight: function() {
            this.photoList.scrollLeft += this.imageOffset * this.imageSlideNumber;
        },

        toLeft: function() {
            this.photoList.scrollLeft -= this.imageOffset * this.imageSlideNumber;
        },

        showAllPhotos: function() {
            this.$emit('showAllPhotos');
        }
    },
};
</script>

<style lang="scss" scoped>

    $blue: #0e71de;

    .photo-slider {
        position: relative;

        &__list {
            overflow: hidden;
            display: flex;
            flex-direction: row;
            margin: 5px;
            scroll-behavior: smooth;
        }

        .slider-arrow {
            position: absolute;
            font-size: 100px;
            top: 25px;
            color: $blue;
            z-index: 2;

            .fas {
                cursor: pointer;

                &:hover {
                    color: darken($blue, 10%);
                }
            }
        }

        &__right-arrow {
            right: -40px;
        }

        &__left-arrow {
            left: -40px;
        }
    }
    @media screen and (max-width: 1085px) {
        .photo-slider{
            &__right-arrow {
                right: 5px;
            }

            &__left-arrow {
                left: 5px;
            }
        }
    }
</style>