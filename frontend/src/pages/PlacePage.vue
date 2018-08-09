<template>
    <div class="place-view container">
        <PlaceTopInfo />
        <div class="main-wrapper columns">
            <div class="column is-two-thirds">
                <div class="main">
                </div>
            </div>
            <PlaceSidebarInfo />
        </div>
    </div>
</template>

<script>
import PlaceSidebarInfo from '@/components/place/PlaceSidebarInfo';
import PlaceTopInfo from '@/components/place/PlaceTopInfo';

export default {
    name: "PlacePage",
    components: {
        PlaceSidebarInfo,
        PlaceTopInfo,
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