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
                    <span>{{ reviews.length }} Reviews</span>
                </div>
                <div class="review-title-search">
                    <div class="control has-icons-left">
                        <input 
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
                                :class="{ active: isActive.popular }"
                            ><a>Popular</a></li>
                            <li
                                @click="onSortFilter('recent')"
                                :class="{ active: isActive.recent }"
                            ><a>Recent</a></li>
                        </ul>
                    </div>
                </div>
                <div class="reviews-section-list">
                    <template v-for="review in currentPlaceReviews.byId">
                        <Review
                            :key="review.id"
                            :review="review"
                        />
                    </template>
                </div>
            </div>
        </template>
    </div>
</template>

<script>
import { mapState } from 'vuex';
import Review from './ReviewListElement';
import AddReview from './AddReview';
import reviewState from '../../store/modules/review/state';

export default {
    components: {
        Review,
        AddReview
    },

    props: {
        place: {
            type: Object,
            required: true
        }
    },

    data() {
        return {
            isActive: {
                popular: true,
                recent: false
            }
        };
    },

    mounted() {
        reviewState.reviews = this.place.reviews;
    },


    computed: {
        ...mapState('place', ['currentPlaceReviews']),

        isReviewsExist() {
            return !_.isEmpty(this.place.reviews);
        }
    },

    methods: {
        onSortFilter(name) {
            for (let item in this.isActive) {
                if (item === name) {
                    this.isActive[item] = true;
                } else {
                    this.isActive[item] = false;
                }
            }
        }
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

</style>