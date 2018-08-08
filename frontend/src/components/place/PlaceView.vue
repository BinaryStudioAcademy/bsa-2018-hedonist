<template>
    <div class="container">
        <PlaceTopInfo />
        <PlaceSidebarInfo />
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

</style>