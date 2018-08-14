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
                    <span>21 Reviews</span>
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
            <div class="add-review">
                <div class="left-side-add-review">
                    <img 
                        src="https://ss0.4sqi.net/img/venuepage/v2/add_tip_blank_avatar@2x-4321684c656168f26ae9208901a9d83e.png" 
                        height="32" 
                        width="32"
                    >
                    <span><a>Login</a>, to leave a review.</span>
                </div>
                <div class="add-review-btn">
                    <button 
                        class="button" 
                        disabled
                    >Post</button>
                </div>
            </div>
        </div>
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
                <template v-for="review in place.reviews">
                    <Review 
                        :key="review.id" 
                        :review="review"
                    />
                </template>
            </div>
        </div>
    </div>
</template>

<script>
import Review from './ReviewListElement';

export default {
    components: {
        Review
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

    computed: {
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

    .add-review {
        padding: 15px;
        display: flex;
        flex-direction: row;
        align-items: center;
        justify-content: space-between;
    }

    .add-review-btn {
        width: 30%;
        display: flex;
        justify-content: flex-end;
    }

    .left-side-add-review {
        width: 50%;
        display: flex;
        flex-direction: row;
        align-items: center;
        justify-content: flex-start;
    }

    .left-side-add-review > img {
        margin-right: 15px;
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