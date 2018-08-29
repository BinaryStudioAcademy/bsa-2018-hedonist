<template>
    <div class="container place-item" v-if="active">
        <div class="media">
            <figure class="media-left image is-128x128">
                <img
                        :src="previewImage"
                >
            </figure>
            <div class="media-content">
                <h3
                        class="title has-text-primary"
                >
                    <router-link :to="`/places/${place.id}`">
                        {{ localizedName }}
                    </router-link>
                </h3>
                <p class="place-city"><strong>{{ city }}</strong></p>
                <p class="place-category">
                    <a href="#">{{ category }}</a>
                </p>
                <p class="address">
                    {{ place.address }}
                </p>
            </div>
            <div class="media-right rating-wrapper">
                <PlaceRating
                        v-if="place.rating"
                        :value="Number(place.rating)"
                />
            </div>
        </div>
        <Review
                v-if="review"
                :review="review"
        />
    </div>
</template>

<script>
    import PlaceRating from '@/components/place/PlaceRating';
    import Review from '@/components/review/PlacePreviewReviewItem';
    import imagePlaceholder from '@/assets/placeholder_128x128.png';
    import {mapState} from 'vuex';

    export default {
        name: "ListPlaceItem",
        components:{PlaceRating,Review},
        computed: {
            ...mapState('userList',['reviews','categories','cities','photos']),
            localizedName() {
                return this.place.localization[0].name;
            },
            previewImage(){
                if(place.photos[0]){
                    return this.place.photos.byId[place.photos[0]];
                }
                return imagePlaceholder;
            },
            city(){
                return this.cities.byId[this.place.id];
            },
            category(){
                return this.categories.byId[this.place.category];
            }

        },
        props: {
            place:{
                type:object,
                required:true
            }
        }
    }
</script>

<style lang="scss" scoped>
    .place-item {
        background: #FFF;
        color: grey;
        max-width: 100%;
        margin-bottom: 1rem;
        padding: 10px;
    }

    .title {
        margin-bottom: 0.5rem;
    }

    .image > img {
        border-radius: 5px;
    }

    .place-category {
        margin-bottom: 0.25rem;
        a {
            color: grey;
            -webkit-transition: color 0.3s;
            -moz-transition: color 0.3s;
            -ms-transition: color 0.3s;
            -o-transition: color 0.3s;
            transition: color 0.3s;

            &:hover {
                color: black;
                text-decoration: underline;
            }
        }
    }

    .address {
        margin-bottom: 0.5rem;
    }

</style>