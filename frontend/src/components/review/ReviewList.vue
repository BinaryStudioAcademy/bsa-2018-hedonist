<template>
    <div class="reviews-wrp">
        <div class="review-title-wrp">
            <div class="review-title">
                <div class="left-side-review-title">
                    <img 
                        src="https://ss1.4sqi.net/img/venuepage/v2/section_title_tips@2x-6449ea09a26b1d885184e709e2c8f693.png" 
                        height="25" 
                        width="25"
                    >
                    <span>{{ this.getTotalReviewCount(this.place.id) }} Reviews</span>
                </div>
                <div class="review-title-search">
                    <div class="control has-icons-left">
                        <input
                            v-model.trim="search"
                            @input="searchReview"
                            class="input is-small" 
                            type="search" 
                            placeholder="Find review.."
                        >
                        <span class="icon is-small is-left">
                            <i class="fas fa-search" />
                        </span>
                    </div>
                </div>
            </div>
        </div>
        <div class="add-review-wrp">
            <AddReview
                :place-id="place.id"
                @add="onAddReview"
            />
        </div>
        <template v-if="isReviewsExist">
            <div class="reviews-section-wrp">
                <div class="reviews-section-header">
                    <div class="filter-area">
                        <ul>
                            <li class="sort-word">Sort by:</li>
                            <li
                                @click="onSortFilter('popular')"
                                :class="{ active: sort === 'popular' }"
                            ><a>Popular</a></li>
                            <li
                                @click="onSortFilter('recent')"
                                :class="{ active: sort === 'recent' }"
                            ><a>Recent</a></li>
                        </ul>
                    </div>
                </div>
                <div
                    v-if="!isLoadingReviews"
                    class="reviews-section-list"
                >
                    <template v-for="(review, index) in reviews">
                        <Review
                            :key="review.id"
                            :review="review"
                            :timer="200 * (index + 1)"
                        />
                    </template>
                    <infinite-loading @infinite="loadNextReviewsPage">
                        <span slot="no-more" />
                        <span slot="no-results" />
                    </infinite-loading>
                </div>
                <div
                    v-else
                    class="preloader"
                >
                    <SmallPreloader :active="isLoadingReviews" />
                </div>
            </div>
        </template>
    </div>
</template>

<script>
import { mapActions, mapGetters } from 'vuex';
import Review from './ReviewListElement';
import AddReview from './AddReview';
import InfiniteLoading from 'vue-infinite-loading';
import SmallPreloader from '@/components/misc/SmallPreloader';

export default {
    components: {
        Review,
        AddReview,
        InfiniteLoading,
        SmallPreloader
    },

    props: {
        place: {
            type: Object,
            required: true
        }
    },

    data() {
        return {
            sort: 'recent',
            visibleReviewsIds: [],
            search: '',
            page: 1,
            isLoadingReviews: false
        };
    },

    computed: {
        ...mapGetters('review', [
            'getPlaceReviewsByIds',
            'getPreloadedRecentPlaceReviewsIds',
            'getPreloadedPopularPlaceReviewsIds',
            'getTotalReviewCount'
        ]),

        reviews() {
            return this.getPlaceReviewsByIds(this.place.id, this.visibleReviewsIds);
        },
        isReviewsExist() {
            return !_.isEmpty(this.reviews);
        },
    },

    methods: {
        ...mapActions('review', ['loadReviewsWithParams']),

        searchReview: _.debounce(function () {
            this.initialLoad();
        }, 250),

        loadNextReviewsPage($state) {
            _.debounce(() => {
                this.loadReviewsWithParams(
                    {
                        placeId: this.place.id,
                        sort: this.sort,
                        text: this.search,
                        page: this.page + 1

                    }
                ).then( res => {
                    if(res.reviews.length === 0){
                        $state.complete();
                    } else{
                        res.reviews.forEach(reviewId => {
                            if (this.visibleReviewsIds.indexOf(reviewId) === -1) {
                                this.visibleReviewsIds.push(reviewId);
                            }
                        });
                        this.page += 1;
                        $state.loaded();
                    }
                }, err => {
                    $state.loaded();
                });
            }, 250)();
        },
        onSortFilter(name) {
            if(this.sort !== name){
                this.sort = name;
                this.initialLoad();
            }
        },
        onAddReview(reviewId) {
            this.visibleReviewsIds.unshift(reviewId);
        },
        initialLoad() {
            this.isLoadingReviews = true;
            if(this.sort === 'popular') {
                this.visibleReviewsIds = this.getPreloadedPopularPlaceReviewsIds(this.place.id);
            }else {
                this.visibleReviewsIds = this.getPreloadedRecentPlaceReviewsIds(this.place.id);
            }
            this.loadReviewsWithParams(
                {
                    placeId: this.place.id,
                    sort: this.sort,
                    text: this.search,
                    page: 1
                }
            ).then( res => {
                this.visibleReviewsIds = res.reviews;
                this.page = 1;
                this.isLoadingReviews = false;
            });
        }
    },
    created(){
        this.initialLoad();

        Echo.private('reviews').listen('.review.added', (payload) => {
            this.$store.commit('review/ADD_REVIEW', payload.review);
            this.$store.commit('review/ADD_REVIEW_USER', payload.user);

            this.visibleReviewsIds.unshift(payload.review.id);
        });

        Echo.private('reviews').listen('.review.photo.added', (payload) => {
            this.$store.commit('review/ADD_REVIEW_PHOTO', {
                reviewId: payload.reviewPhoto.review_id,
                img_url: payload.reviewPhoto.img_url,
            });
            this.$store.commit('review/ADD_PLACE_REVIEW_PHOTO', payload.reviewPhoto);
        });
    }
};

</script>

<style scoped>

    /* Main block wrapper. */
    .reviews-wrp {
        margin: auto;
        font-size: 18px;
        color: #808080;
        background: #f7f7f7;
        border: 1px solid #efeff4;
    }

    /* Review list title part. */
    .review-title-wrp {
        background: #fff;
        margin-bottom: 15px;
        border: 1px solid #efeff4;
    }

    .review-title {
        padding: 15px;
        display: flex;
        flex-direction: row;
        align-items: center;
        justify-content: space-between;
    }

    .review-title-search {
        width: 30%;
    }

    .left-side-review-title {
        width: 50%;
        display: flex;
        flex-direction: row;
        align-items: center;
        justify-content: flex-start;
    }

    .left-side-review-title > img {
        margin-right: 10px;
    }


    /* Add review list part. */
    .add-review-wrp {
        background: #fff;
        margin-top: 15px;
        margin-bottom: 15px;
        border: 1px solid #efeff4;
    }

    /* Review list part. */
    .reviews-section-wrp {
        background: #fff;
        margin-top: 15px;
        border: 1px solid #efeff4;
    }

    .reviews-section-header {
        border-bottom: 1px solid #efeff4;
    }

    .filter-area {
        margin-left: 15px;
        margin-right: 15px;
    }

    ul {
        margin: 0;
        padding: 0;
        display: flex;
        list-style-type: none;
        justify-content: flex-start;
    }

    li {
        padding: 10px;
        text-decoration: none;
    }

    li:first-child {
        padding-left: 0;
    }

    .active {
        background: #efeff4;
    }

    .sort-word {
        color: #808080;
    }

    .preloader {
        padding: 20px;
    }

</style>