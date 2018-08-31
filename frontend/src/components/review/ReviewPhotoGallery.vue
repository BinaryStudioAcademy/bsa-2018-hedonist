<template>
    <div class="reviews-photos-wrp">
        <div class="review-title">
            <div class="left-side-review-title">
                <img 
                    src="https://ss0.4sqi.net/img/venuepage/v2/section_title_photos-8f94fe369722d78e2322dec97fa9488d.png" 
                    height="25" 
                    width="25"
                >
                <span v-if="loaded">{{ photosCount }} Photos</span>
            </div>
        </div>
        <ul class="reviews-photo-list">
            <li
                v-if="loaded"
                v-for="(photo, index) in photos"
                :key="index"
            >
                <ReviewPhoto
                    :photo="photo"
                />
            </li>
        </ul>
    </div>
</template>

<script>
import ReviewPhoto from './ReviewPhoto';
import { mapGetters } from 'vuex';

export default {
    name: 'ReviewPhotoGallery',
    components: { 
        ReviewPhoto 
    },
    props: {
        place: {
            type: Object,
            required: true
        },
        isLoadingReviewPhoto: {
            type: Boolean,
            required: true
        }
    },
    computed: {
        ...mapGetters({
            placeReviewPhotos: 'review/getPlaceReviewPhotos',
        }),
        photosCount() {
            return this.place.photos.length + this.placeReviewPhotos.length;
        },
        loaded() {
            return !(this.isLoadingReviewPhoto) && !!(this.placeReviewPhotos);
        },
        photos() {
            let placePhotos = Object.values(this.place.photos);
            let placeReviewPhotos = Object.values(this.placeReviewPhotos);
            return placePhotos.concat(placeReviewPhotos);
        }
    }
};
</script>

<style lang="scss" scoped>

    .reviews-photo-list {
        display: grid;
        grid-gap: 10px;
        grid-template-columns: repeat(auto-fill, minmax(200px, 1fr));
        padding: 15px;
        padding-top: 0;
    }
    
    .reviews-photos-wrp {
        margin: auto;
        font-size: 18px;
        color: #808080;
        background: #fff;
        border: 1px solid #efeff4;
    }

    .review-title-wrp {
        background: #fff;
        margin-bottom: 15px;
        border: 1px solid #efeff4;
    }

    .review-title {
        padding: 15px;
        display: flex;
        flex-direction: row;
        align-items: center;
        justify-content: space-between;
    }

    .left-side-review-title {
        width: 50%;
        display: flex;
        flex-direction: row;
        align-items: center;
        justify-content: flex-start;
    }

    .left-side-review-title > img {
        margin-right: 10px;
    }

    .reviews-section-wrp {
        background: #fff;
        margin-top: 15px;
        border: 1px solid #efeff4;
    }

</style>