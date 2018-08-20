<template>
    <div class="place-view container">
        <b-loading :active.sync="isLoading" />
        <PlaceTopInfo 
            v-if="loaded"
            :place="currentPlace"
            @tabChanged="tabChanged"
        />
        <div class="main-wrapper columns">
            <div class="column is-two-thirds">
                <div class="main">
                    <ReviewList 
                        v-if="loaded && (activeTab === 1) && currentPlace.reviews"
                        :place="currentPlace"
                    />
                    <ReviewPhotoGallery 
                        v-if="loaded && (activeTab === 2) && currentPlace.photos"
                        :place="currentPlace"
                    />
                </div>
            </div>
            <PlaceSidebarInfo 
                v-if="loaded"
                :place="currentPlace"
            />
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
    name: 'PlacePage',

    components: {
        PlaceTopInfo,
        ReviewList,
        ReviewPhotoGallery,
        PlaceSidebarInfo
    },

    data() {
        return {
            isLoading: true,
            loaded: false,
            activeTab: 1,
            place: null
        };
    },

    created() {
        this.$store.dispatch('place/loadCurrentPlace', this.$route.params.id)
            .then((response) => {
                this.isLoading = false;
                this.loaded = true;
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
        ...mapState('place', ['currentPlace'])
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