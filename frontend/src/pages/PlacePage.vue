<template>
    <div class="place-view container">
        <b-loading :active.sync="isLoading"></b-loading>
        <PlaceTopInfo v-if="!isLoading" :place="place" />
        <div class="main-wrapper columns">
            <div class="column is-two-thirds">
                <div class="main">
                    <ReviewList v-if="!isLoading" :place="place"></ReviewList>
                </div>
            </div>
            <PlaceSidebarInfo v-if="!isLoading" :place="place" />
        </div>
    </div>
</template>

<script>
    import PlaceTopInfo from '@/components/place/PlaceTopInfo';
    import ReviewList from '@/components/review/ReviewList';
    import PlaceSidebarInfo from '@/components/place/PlaceSidebarInfo';
    import { mapGetters } from 'vuex';

    export default {
        name: "PlacePage",
        components: {
            PlaceTopInfo,
            ReviewList,
            PlaceSidebarInfo
        },
        data() {
            return {
                place: null,
                isLoading: true,
            }
        },
        created() {
            this.getById(this.$route.params.id).then(place => {
                this.place = place;
                this.isLoading = false;
            });
        },
        computed: {
            ...mapGetters('place', ['getById'])
        },
    }
</script>

<style scoped>
    .main-wrapper {
        margin-top: 20px;
    }

    .main {
        background-color: white;
    }
</style>