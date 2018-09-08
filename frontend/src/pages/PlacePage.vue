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
                        v-if="loaded && (activeTab === 1)"
                        :place="place"
                    />
                    <ReviewPhotoGallery
                        v-if="loaded && (activeTab === 2)"
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
import { mapState, mapMutations } from 'vuex';

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
        const placeId = this.$route.params.id;
        this.loadPlace(placeId);
        this.listen(placeId);
    },

    methods: {
        ...mapMutations('place', {
            addVisitor      : 'ADD_PAGE_VISITOR',
            removeVisitor   : 'REMOVE_PAGE_VISITOR',
            clearVisitors    : 'CLEAR_PAGE_VISITORS',
        }),
        listen(placeId) {
            const channel = 'place.'+placeId;
            Echo.join(channel)
                .here((users) => {
                    this.clearVisitors();
                    users.forEach( user => {
                        this.addVisitor(user);
                    });
                })
                .joining((user) => {
                    this.addVisitor(user);
                })
                .leaving((user) => {
                    this.removeVisitor(user);
                });
        },
        tabChanged(activeTab) {
            this.activeTab = activeTab;
        },
        loadPlace(id) {
            this.isLoading = true;
            this.isLoadingReviewPhoto = true;
            this.$store.dispatch('place/loadCurrentPlace', id)
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
        }
    },

    computed: {
        ...mapState('place', {
            places      : 'places',
            place       : 'currentPlace',
            visitors    : 'visitors',
        }),
        loaded: function() {
            return !!(this.place) && !(this.isLoading);
        }
    },

    watch: {
        '$route' (to, from) {
            this.loadPlace(to.params.id);
        }
    }
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