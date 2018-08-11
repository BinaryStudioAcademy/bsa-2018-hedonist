<template>
    <div class="place-view container">
        <b-loading :active.sync="isLoading"></b-loading>
        <PlaceTopInfo v-if="!isLoading" v-bind:place="currentPlace" />
        <div class="main-wrapper columns">
            <div class="column is-two-thirds">
                <div class="main">
                    <ReviewList></ReviewList>
                </div>
            </div>
            <PlaceSidebarInfo v-if="!isLoading" v-bind:place="currentPlace" />
        </div>
    </div>
</template>

<script>
import ReviewList from '@/components/review/ReviewList';
import PlaceSidebarInfo from '@/components/place/PlaceSidebarInfo';
import PlaceTopInfo from '@/components/place/PlaceTopInfo';
import { mapState, mapGetters, mapActions } from "vuex";

export default {
    name: "PlacePage",
    components: {
        PlaceTopInfo,
        ReviewList,
        PlaceSidebarInfo
    },
    data() {
        return {
            isLoading: true,
            id: this.$route.params.id
        };
    },
    created() {
        this.$store.dispatch('place/loadCurrentPlace', this.id)
            .finally(() => this.isLoading = false);
    },
    computed: {
        ...mapState('place', ['currentPlace'])
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