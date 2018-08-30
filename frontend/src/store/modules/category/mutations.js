export default {
    SET_ALL_CATEGORIES: (state, categories) => {
        state.allCategories = Object.assign({}, categories);
    },

    SET_CATEGORY_TAGS: (state, tags) => {
        state.categoryTags = Object.assign({}, tags);
    },
};
