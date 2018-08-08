<template>
    <div class="place-photo">
        <img class="place-photo__image" :src="photo.url" alt="place image">
    </div>
</template>

<script>
export default {
    name: "PlacePhoto",
    props: {
        photo: {
            type: Object,
            required: true
        }
    },
}
</script>

<style lang="scss">

.place-photo {
    width: 200px;
    height: 200px;
    margin-right: 10px;
    overflow: hidden;
    position: relative;

    &__image {
        position:absolute;
        top:0;
        bottom:0;
        right: 0;
        margin: auto;
        height: 100%;
    }
}

</style>