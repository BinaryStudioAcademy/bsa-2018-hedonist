<template>
    <ul class="place-photo-list">
        <li v-for="photo in photos" :key="photo.id">
            <PlacePhoto :key="photo.id" :photo="photo" />
        </li>
    </ul>
</template>

<script>
import PlacePhoto from './PlacePhoto';

export default {
    name: "PlacePhotoList",
    components: { PlacePhoto },
    data() {
        return {
            photos: [
                {id: 1, url: 'https://goo.gl/Vi38JD'},
                {id: 2, url: 'https://goo.gl/Vi38JD'},
                {id: 3, url: 'https://goo.gl/Vi38JD'},
                {id: 4, url: 'https://goo.gl/Vi38JD'},
                {id: 5, url: 'https://goo.gl/Vi38JD'},
                {id: 6, url: 'https://goo.gl/Vi38JD'},
                {id: 7, url: 'https://goo.gl/Vi38JD'},
                {id: 8, url: 'https://goo.gl/Vi38JD'},
                {id: 9, url: 'https://goo.gl/Vi38JD'},
            ]
        };
    },
}
</script>

<style lang="scss" scoped>

.place-photo-list {
    display: flex;
    flex-direction: row;
    margin: 5px;
    overflow: auto;
}

</style>