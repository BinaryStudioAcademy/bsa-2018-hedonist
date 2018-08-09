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
import PlaceSidebarInfo from './PlaceSidebarInfo';
import PlaceTopInfo from './PlaceTopInfo';

export default {
    name: "PlaceView",
    components: {
        PlaceSidebarInfo,
        PlaceTopInfo,
    },
}
</script>

<style>

.main-wrapper {
    margin-top: 20px;
}
.main {
    background-color: white;
}
</style>