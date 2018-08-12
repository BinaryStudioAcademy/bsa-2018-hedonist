<template>
    <div class="place-view container">
        <PlaceTopInfo />
        <div class="main-wrapper columns">
            <div class="column is-two-thirds">
                <div class="main">
                    <ReviewList></ReviewList>
                </div>
            </div>
            <PlaceSidebarInfo />
        </div>
    </div>
</template>

<script>
    import PlaceTopInfo from '@/components/place/PlaceTopInfo';
    import ReviewList from '@/components/review/ReviewList';
    import ReviewsPhotos from '@/components/review/ReviewsPhotos';
    import PlaceSidebarInfo from '@/components/place/PlaceSidebarInfo';

export default {
    name: "PlacePage",
    components: {
        PlaceTopInfo,
        ReviewList,
        ReviewsPhotos,
        PlaceSidebarInfo
    },
}
</script>

<style scoped>
    .main-wrapper {
        margin-top: 20px;
    }

    .main {
        background-color: white;
    }
</style>