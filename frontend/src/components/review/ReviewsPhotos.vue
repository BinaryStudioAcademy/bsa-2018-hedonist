<template>
    <div class="reviews-photos-wrp">
        <div class="review-title">
            <div class="left-side-review-title">
                <img src="https://ss0.4sqi.net/img/venuepage/v2/section_title_photos-8f94fe369722d78e2322dec97fa9488d.png" height="25" width="25">
                <span>321 Photos</span>
            </div>
        </div>
        <ul class="reviews-photo-list">
            <li v-for="photo in photos" :key="photo.id">
                <ReviewPhoto :key="photo.id" :photo="photo" />
            </li>
        </ul>
    </div>
</template>

<script>
    import ReviewPhoto from './ReviewPhoto';

    export default {
        name: "ReviewsPhotos",

        components: { 
            ReviewPhoto 
        },

        props: {
            place: {
                type: Object,
                required: true
            }
        },

        data() {
            return {
                photos: [
                    {id: 1, url: 'https://goo.gl/Ch8Ke9'},
                    {id: 2, url: 'https://goo.gl/x3AmSY'},
                    {id: 3, url: 'https://goo.gl/WfviVp'},
                    {id: 4, url: 'https://goo.gl/QwdfPG'},
                    {id: 5, url: 'https://goo.gl/TAVDcL'},
                    {id: 6, url: 'https://goo.gl/f7zX7n'},
                    {id: 7, url: 'https://goo.gl/LYwf2U'},
                    {id: 8, url: 'https://goo.gl/mjRgka'},
                    {id: 9, url: 'https://goo.gl/jbeku1'},
                    {id: 10, url: 'https://goo.gl/K6Zjgc'},
                    {id: 11, url: 'https://goo.gl/5KJYTS'},
                ]
            };
        },
    }   
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