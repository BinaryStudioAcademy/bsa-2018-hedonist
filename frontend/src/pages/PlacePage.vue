<template>
    <div class="place-view container">
        <b-loading :active.sync="isLoading"></b-loading>
<!--<<<<<<< HEAD-->
        <!--<PlaceTopInfo v-if="!isLoading" :place="currentPlace" />-->
        <!--<div class="main-wrapper columns">-->
            <!--<div class="column is-two-thirds">-->
                <!--<div class="main">-->
                    <!--<ReviewList v-if="!isLoading" :place="currentPlace"></ReviewList>-->
<!--=======-->
        <PlaceTopInfo v-if="!isLoading" :place="currentPlace" @tabChanged="tabChanged" />
        <div class="main-wrapper columns">
            <div class="column is-two-thirds">
                <div class="main">
                    <ReviewList v-if="!isLoading && (activeTab === 1)" :place="currentPlace"></ReviewList>
                    <ReviewPhotoGallery v-if="!isLoading && (activeTab === 2)" :place="currentPlace"></ReviewPhotoGallery>
                </div>
            </div>
            <PlaceSidebarInfo v-if="!isLoading" :place="currentPlace" />
        </div>
    </div>
</template>

<script>
    import PlaceTopInfo from '@/components/place/PlaceTopInfo';
    import ReviewList from '@/components/review/ReviewList';
    import ReviewPhotoGallery from '@/components/review/ReviewPhotoGallery';
    import PlaceSidebarInfo from '@/components/place/PlaceSidebarInfo';
    import { mapState } from 'vuex';

    export default {
        name: "PlacePage",

        components: {
            PlaceTopInfo,
            ReviewList,
            ReviewPhotoGallery,
            PlaceSidebarInfo
        },

        data() {
            return {
                isLoading: true,
                activeTab: 1
            }
        },

        created() {
            this.$store.dispatch('place/loadCurrentPlace', this.$route.params.id)
                .finally(() => this.isLoading = false);
        },

        methods: {
            tabChanged(activeTab) {
                this.activeTab = activeTab;
            }
        },

        computed: {
            ...mapState('place', ['currentPlace'])
        },
    }
// =======
//     import PlaceTopInfo from '@/components/place/PlaceTopInfo';
//     import ReviewList from '@/components/review/ReviewList';
//     import ReviewPhotoGallery from '@/components/review/ReviewPhotoGallery';
//     import PlaceSidebarInfo from '@/components/place/PlaceSidebarInfo';
//     import { mapGetters } from 'vuex';
//
//     export default {
//         name: "PlacePage",
//
//         components: {
//             PlaceTopInfo,
//             ReviewList,
//             ReviewPhotoGallery,
//             PlaceSidebarInfo
//         },
//
//         data() {
//             return {
//                 place: null,
//                 isLoading: true,
//                 activeTab: 1
//             }
//         },
//
//         created() {
//             this.getById(this.$route.params.id).then(place => {
//                 this.place = place;
//                 this.isLoading = false;
//             });
//         },
//
//         methods: {
//             tabChanged(activeTab) {
//                 this.activeTab = activeTab;
//             }
//         },
//
//         computed: {
//             ...mapGetters('place', ['getById'])
//         },
//     }
// >>>>>>> development
</script>

<style lang="scss" scoped>
.main-wrapper {
    margin-top: 20px;
}

.loader-wrapper {
    position: fixed;
    top: 0;
    bottom: 0;
    left: 0;
    right: 0;
    background-color: rgba(0, 0, 0, 0.1);

    .loader {
        width: 100px;
        height: 100px;
        z-index: 5000;
    }
}

.main {
    background-color: white;
}
</style>