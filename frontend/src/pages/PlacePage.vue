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
    import ReviewPhotos from '@/components/review/ReviewPhotos';
    import PlaceSidebarInfo from '@/components/place/PlaceSidebarInfo';

export default {
    name: "PlacePage",
    components: {
        PlaceTopInfo,
        ReviewList,
        ReviewPhotos,
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