<template>
    <div class="reviews-photo">
        <img
            v-img:review-group
            class="reviews-photo__image" 
            :src="photo['img_url']"
            :alt="photo.description"
        >
    </div>
</template>

<script>
export default {
    name: 'ReviewPhoto',
    props: {
        photo: {
            type: Object,
            required: true
        }
    },
};
</script>

<style lang="scss" scoped>

.reviews-photo {
    width: 200px;
    height: 200px;

    &__image {
        width: 100%;
        height: 100%;
        object-fit: cover;
        object-position: 50% 50%;
    }
}

</style>