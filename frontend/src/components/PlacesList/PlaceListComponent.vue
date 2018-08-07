<template>
    <transition>
        <div class="container">
            <div class="row">
                <div class="col-md-4">
                    <div class="img-fluid">
                        <img :src="place.image">
                    </div>
                </div>
                <div class="col-md-8">
                    <div class = "row">
                        <div>
                    </div>
                </div>
            </div>
        </div>
    </transition>
    >
</template>

<script>
    export default {
        name: "PlaceListComponent",
        props:
            {
                place:
                    {
                        required: true,
                        type: Object,
                    }
            },
    }
</script>

<style lang="scss" scoped>

</style>