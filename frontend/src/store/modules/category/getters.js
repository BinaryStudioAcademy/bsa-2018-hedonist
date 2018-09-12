export default {
    categoryTagsList: state => {
        const categoryTags = state.categoryTags.byId;
        const neededKeys = ['id', 'name'];
        let categoryTagsList = [];

        if (!categoryTags) {
            return categoryTagsList;
        }

        for (let id in categoryTags) {
            categoryTagsList.push(
                Object.keys(categoryTags[id])
                    .filter(key => neededKeys.includes(key))
                    .reduce((obj, key) => {
                        obj[key] = categoryTags[id][key];
                        return obj;
                    }, {})
            );
        }

        return categoryTagsList;
    },

    getById: state => id => {
        return state.allCategories[id];
    },
};
