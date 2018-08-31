<template>
    <div class="place-view container">
        <Preloader :active="isLoading" />
        <PlaceTopInfo 
            v-if="loaded"
            :place="place"
            :is-loading-review-photo="isLoadingReviewPhoto"
            @tabChanged="tabChanged"
        />
        <div class="main-wrapper columns">
            <div class="column is-two-thirds">
                <div class="main">
                    <ReviewList 
                        v-if="loaded && (activeTab === 1) && place.reviews"
                        :place="place"
                    />
                    <ReviewPhotoGallery 
                        v-if="loaded && (activeTab === 2) && place.photos"
                        :place="place"
                        :is-loading-review-photo="isLoadingReviewPhoto"
                    />
                </div>
            </div>
            <PlaceSidebarInfo 
                v-if="loaded"
                :place="place"
            />
        </div>
    </div>
</template>

<script>
import Preloader from '@/components/misc/Preloader';
import PlaceTopInfo from '@/components/place/PlaceTopInfo';
import ReviewList from '@/components/review/ReviewList';
import ReviewPhotoGallery from '@/components/review/ReviewPhotoGallery';
import PlaceSidebarInfo from '@/components/place/PlaceSidebarInfo';
import { mapState } from 'vuex';

export default {
    name: 'PlacePage',

    components: {
        PlaceTopInfo,
        ReviewList,
        ReviewPhotoGallery,
        PlaceSidebarInfo,
        Preloader
    },

    data() {
        return {
            isLoading: true,
            isLoadingReviewPhoto: true,
            activeTab: 1,
        };
    },

    created() {
        this.$store.dispatch('place/loadCurrentPlace', this.$route.params.id)
            .then((response) => {
                this.isLoading = false;
                this.$store.dispatch('review/getReviewPhotosByPlace', this.place.id)
                    .then((response) => {
                        this.isLoadingReviewPhoto = false;
                    })
                    .catch((err) => {
                        this.isLoadingReviewPhoto = false;
                    });
            })
            .catch((err) => {
                this.isLoading = false;
            });

    },

    methods: {
        tabChanged(activeTab) {
            this.activeTab = activeTab;
        }
    },

    computed: {
        ...mapState('place', {
            places  : 'places',
            place   : 'currentPlace'
        }),
        loaded: function() {
            return !!(this.place) && !(this.isLoading);
        }
    },
};
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