<template>
    <div class="place-photo">
        <img class="place-photo__image" @click="showModal(photo.url)" :src="photo.url" alt="place image">
        <div v-if="photo.id === lastId" class="place-photo__show-all"><a href="#">Show all</a></div>
    </div>
</template>

<script>
export default {
    name: "PlacePhoto",
    props: {
        photo: {
            type: Object,
            required: true
        },
        lastId: {
            type: Number
        }
    },
    methods: {
        showModal: function(url) {
            var modal = document.getElementById('imgFullModal');
            modal.style.display = "block";

            var modalImg = document.getElementById("imgPlacePhoto");
            modalImg.src = url;

            var span = document.getElementsByClassName("closeModal")[0];

            span.onclick = function() {
                modal.style.display = "none";
            }
        }
    }
}
</script>

<style lang="scss" scoped>

.place-photo {
    width: 200px;
    height: 200px;
    margin-right: 10px;
    overflow: hidden;
    position: relative;

    &__image {
        position:absolute;
        top: 0;
        bottom: 0;
        right: 0;
        left: 0;
        margin: auto;
    }

    &__show-all {
        position:absolute;
        display: flex;
        justify-content: center;
        align-items: center;
        top: 0;
        bottom: 0;
        right: 0;
        left: 0;
        background-color: rgba(0, 0, 0, 0.5);
        text-align: center;
        a {
            color: white;

            &:hover {
                text-decoration: underline;
            }
        }
    }
}

</style>