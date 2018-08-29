<template>
    <div class="category-tags">
        <span class="category-tags__title">Show only:</span>

        <div class="tags">
            <CategoryTag v-for="tag in tags" :key="tag.id" :tag="tag" />
        </div>
    </div>    
</template>

<script>
import CategoryTag from './CategoryTag';

export default {
    name: 'CategoryTagsContainer',

    components: {
        CategoryTag,
    },

    props: {
        tags: {
            required: true,
            type: Array,
        },
    },
};
</script>

<style lang="scss" scoped>
    .category-tags {
        background: #f8f8f8;
        border-top: 1px solid #fff;
        border-bottom: 1px solid #e4e4e4;
        padding: 5px 16px 8px 16px;

        &__title {
            color: #6e6e6e;
            font-size: 11px;
            float: left;
            margin: 6px 5px 0 0;
            text-shadow: 0 1px 0 #fff;
            line-height: 100%;
            font-weight: bold;
        }
    }
</style>
