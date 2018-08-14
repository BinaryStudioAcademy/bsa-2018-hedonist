<template>
    <div class="photo-slider">
        <ImageSwipe :items="photos"></ImageSwipe>
    </div>
</template>

<script>
    import ImageSwipe from '../image/ImageSwipe';

export default {
    name: "PlacePhotoList",
    components: { ImageSwipe },
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
}
</script>

<style>
    .photo-slider .my-gallery {
        display: inline-flex;
    }
    .photo-slider figure a img{
        min-width: 200px;
    }
</style>

<style lang="scss" scoped>
    .photo-slider {
        overflow-x: scroll;
    }
</style>