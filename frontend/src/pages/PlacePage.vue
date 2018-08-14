<template>
    <div class="place-view container">
        <b-loading :active.sync="isLoading" />
        <PlaceTopInfo 
            v-if="!isLoading" 
            :place="place" 
            @tabChanged="tabChanged"
        />
        <div class="main-wrapper columns">
            <div class="column is-two-thirds">
                <div class="main">
                    <ReviewList 
                        v-if="!isLoading && (activeTab == 1)" 
                        :place="place"
                    />
                    <ReviewPhotoGallery 
                        v-if="!isLoading && (activeTab == 2)" 
                        :place="place"
                    />
                </div>
            </div>
            <PlaceSidebarInfo 
                v-if="!isLoading" 
                :place="place"
            />
        </div>
    </div>
</template>

<script>
import PlaceTopInfo from '@/components/place/PlaceTopInfo';
import ReviewList from '@/components/review/ReviewList';
import ReviewPhotoGallery from '@/components/review/ReviewPhotoGallery';
import PlaceSidebarInfo from '@/components/place/PlaceSidebarInfo';
import { mapGetters } from 'vuex';

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
            place: null,
            isLoading: true,
            activeTab: 1
        };
    },

    created() {
        this.getById(this.$route.params.id).then(place => {
            this.place = place;
            this.isLoading = false;
        });
    },

    methods: {
        tabChanged(activeTab) {
            this.activeTab = activeTab;
        }
    },

    computed: {
        ...mapGetters('place', ['getById'])
    },
};
</script>

<style scoped>
    .main-wrapper {
        margin-top: 20px;
    }

    .main {
        background-color: white;
    }
</style>