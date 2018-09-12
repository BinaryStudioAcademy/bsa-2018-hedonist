<template>
    <div class="no-results">
        <div class="no-results__title has-text-weight-bold">{{ $t('place_page.no_result_reviews.title') }}</div>

        <div class="no-results__try">{{ $t('place_page.no_result_reviews.may_try') }}</div>
        <ul>
            <li>{{ $t('place_page.no_result_reviews.clear_query') }}</li>
            <li>{{ $t('place_page.no_result_reviews.change_query') }}</li>
            <li>{{ $t('place_page.no_result_reviews.be_first') }}</li>
        </ul>
    </div>
</template>

<script>
export default {
    name: 'NoReviewsFound'
};
</script>

<style lang="scss" scoped>
    .no-results {
        text-align: left;
        padding: 30px 50px;

        &__title {
            margin-bottom: 20px;
        }
        &__try {
            font-weight: 500;
            margin-bottom:5px;
        }

        ul {
            margin-left: 20px;

            li {
                font-size: 0.9rem;
                list-style: disc;
            }
        }
    }
</style>