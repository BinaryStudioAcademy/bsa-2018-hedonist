<template>
    <div class="container">
        <div class="columns">
            <div class="main-part column is-two-thirds">
                <div class="name-row">
                    <span>Name:</span>
                    <div class="control">
                        <input class="input" type="text" placeholder="Text input">
                    </div>
                </div>
            </div>
            <div class="map-part column">
                <div class="map-box">
                    <img src="https://a.tiles.mapbox.com/v3/foursquare.qhb8olxr/16/38326/22101.png" alt="mapbox">
                </div>
            </div>
        </div>
    </div>
</template>

<script>
    export default {
        name: "NewPlacePage"
    }
</script>

<style lang="scss" scoped>

    .map-box {
        padding: 10px;

        img {
            width: 100%;
        }
    }

</style>