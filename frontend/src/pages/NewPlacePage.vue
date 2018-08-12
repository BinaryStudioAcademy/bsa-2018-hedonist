<template>
    <div class="section">
        <div class="container main-wrp columns">
            <div class="main-part column is-two-thirds">
                <div class="field is-horizontal">
                    <div class="field-label is-medium">
                        <label class="label">Name</label>
                    </div>
                    <div class="field-body">
                        <div class="field">
                            <div class="control is-expanded">
                                <input class="input is-medium" type="text" placeholder="Place's name">
                            </div>
                        </div>
                    </div>
                </div>

                <h4>Address and Location</h4>

                <div class="field is-horizontal">
                    <div class="field-label is-normal">
                        <label class="label">City</label>
                    </div>
                    <div class="field-body">
                        <div class="field">
                            <p class="control is-expanded">
                                <input class="input" type="text" placeholder="Place's city">
                            </p>
                        </div>
                        <div class="field-label is-normal">
                            <label class="label">Zip</label>
                        </div>
                        <div class="field">
                            <p class="control is-expanded">
                                <input class="input" type="text" placeholder="Place's postal code">
                            </p>
                        </div>
                    </div>
                </div>

                <div class="field is-horizontal">
                    <div class="field-label is-normal">
                        <label class="label">Address</label>
                    </div>
                    <div class="field-body">
                        <div class="field">
                            <div class="control is-expanded">
                                <input class="input" type="text" placeholder="Place's address">
                            </div>
                        </div>
                    </div>
                </div>

                <h4>Contact and Other Info</h4>

                <div class="field is-horizontal">
                    <div class="field-label is-normal">
                        <label class="label">Phone</label>
                    </div>
                    <div class="field-body">
                        <div class="field">
                            <p class="control is-expanded">
                                <input class="input" type="tel" placeholder="Place's phone">
                            </p>
                        </div>
                        <div class="field-label is-normal">
                            <label class="label">Website</label>
                        </div>
                        <div class="field">
                            <p class="control is-expanded">
                                <input class="input" type="text" placeholder="Place's website">
                            </p>
                        </div>
                    </div>
                </div>

                <div class="field is-horizontal">
                    <div class="field-label is-normal">
                        <label class="label">Description</label>
                    </div>
                    <div class="field-body">
                        <div class="field">
                            <div class="control">
                                <textarea class="textarea" placeholder="Place's description.."></textarea>
                            </div>
                        </div>
                    </div>
                </div>

                <div class="field is-horizontal">
                    <div class="field-label"></div>
                    <div class="field-body">
                        <div class="field">
                            <div class="control">
                                <button class="button is-primary">
                                    Add place
                                </button>
                            </div>
                        </div>
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

    .section {
        padding-top: 24px;
    }

    .main-wrp {
        margin: auto;
    }

    .name-block {
        display: flex;
        flex-direction: row;
        justify-content: space-between;
        align-items: center;

        span {
            text-align: center;
        }
    }



    .map-box {
        img {
            width: 100%;
        }
    }

</style>