<template>
    <div class="place-view container">
        <b-loading :active.sync="isLoading"></b-loading>
        <PlaceTopInfo v-if="!isLoading" :place="place" @tabChanged="tabChanged" />
        <div class="main-wrapper columns">
            <div class="column is-two-thirds">
                <div class="main">
                    <ReviewList v-if="!isLoading && (activeTab === 1)" :place="places[0]"></ReviewList>
                    <ReviewPhotoGallery v-if="!isLoading && (activeTab === 2)" :place="places[0]"></ReviewPhotoGallery>
                </div>
            </div>
            <PlaceSidebarInfo v-if="!isLoading" :place="place" />
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
            ...mapState('place', ['place']),
            ...mapState('place', ['places'])
        },
    }
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