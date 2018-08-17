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
                v-for="photo in photos"
                :key="photo.id"
            >
                <PlacePhoto
                    :key="photo.id"
                    :photo="photo"
                    :last-id="photos.length"
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
        place: {
            type: Object,
            required: true
        }
    },
    data() {
        return {
            photos: [
                {id: 1, url: 'https://igx.4sqi.net/img/general/200x200/887035_CLhGX1rsu2-V75shOAkPWuxXLY2k4iO17hEdOlOfSWc.jpg'},
                {id: 2, url: 'https://igx.4sqi.net/img/general/200x200/26166006_NbsG6630seaUu5oBMHF1nJN5faMbAJBB-U_fftfgLQ0.jpg'},
                {id: 3, url: 'https://igx.4sqi.net/img/general/200x200/14194563_V7QcNe7QxElooKfHflch-zJsOky6c58iNIMq5_gqf2g.jpg'},
                {id: 4, url: 'https://igx.4sqi.net/img/general/200x200/30460270_jXczXSrGxp69jx5_iU-NXRoxXfZl1OKMqrbSRL5IOh4.jpg'},
                {id: 5, url: 'https://igx.4sqi.net/img/general/200x200/49523061_7l_R5LyP657g624USxZ_oomdQ3QkqJyI0OvSdKGQLsY.jpg'},
                {id: 6, url: 'https://igx.4sqi.net/img/general/200x200/43170088_MOsT6vDk8CrgoM8hMPQ2Ex1OLGUR3SBJJP8CKK317_s.jpg'},
                {id: 7, url: 'https://igx.4sqi.net/img/general/200x200/5131275_W0cHIwqqMi95dCIhgAiTdDFBySZL4xsS93Prjxv8GJM.jpg'},
                {id: 8, url: 'https://igx.4sqi.net/img/general/200x200/83196834_6Jkr24BOV5h52EMvb8cy9oeP5IdcZdSfmNzazYBEz_g.jpg'},
                {id: 9, url: 'https://igx.4sqi.net/img/general/200x200/81501175_U8dlSYQ2mFeWzRszG5Pu57VRW2CdwypUC3ofR8dnT1I.jpg'},
                {id: 10, url: 'https://igx.4sqi.net/img/general/200x200/127740585_BCMwhYAAZ8lyVb5wdDXytxSRSPdBkjaYY6pFRO6yW-g.jpg'},
                {id: 11, url: 'https://igx.4sqi.net/img/general/200x200/105415509_EgiwmKD9QYjKut0p9Fuj4FmUM3qJIX2LFsORO3R9P58.jpg'},
                {id: 12, url: 'https://igx.4sqi.net/img/general/200x200/91146561_OPnRUeFJtkM8ZNTdkK4VhAnY99eqHtzGqY9EykWU22A.jpg'},
            ],
            photoList: null,
            imageOffset: null,
            imageSlideNumber: 2
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