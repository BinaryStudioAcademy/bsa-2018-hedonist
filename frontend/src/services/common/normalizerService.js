export const normalizerService = {

    normalize(response, shape = {}) {
        let result = {};

        if (Array.isArray(response.data)) {
            result = this.normalizeArray(response.data, shape);
        } else {
            result = this.normalizeObject(response.data, shape);
        }

        return {
            byId: result
        };
    },

    normalizeArray(data, shape){
        return data.reduce((normalizedObject, item) => {
            return Object.assign(normalizedObject, this.normalizeObject(item,shape));
        }, {});
    },

    normalizeObject(data, shape){
        if('id' in data){
            return {
                [data.id]: Object.assign({}, shape, data)
            };
        } else{
            return {};
        }
    },

    updateNormalizedData(targetNormalized, sourceNormalized){
        if (targetNormalized.byId === undefined)
            targetNormalized.byId = {};
        for (let el in sourceNormalized.byId){
            let elId = parseInt(el);
            targetNormalized.byId[elId] = sourceNormalized.byId[elId];
        }
        return targetNormalized;
    },

    updateAllIds(targetNormalized){
        if (targetNormalized.allIds === undefined)
            targetNormalized.allIds = [];
        for (let el in targetNormalized.byId){
            targetNormalized.allIds.push(parseInt(el));
        }
        return targetNormalized;
    },

    normalizeReviews(reviews) {
        let allIds = [];
        reviews.forEach(function (review) {
            review.user_id = review.user.id;
            allIds.push(review.id);
        });
        let transformedCurrentPlaceReviews = normalizerService.normalize(
            {data: reviews},
            this.getReviewSchema()
        );
        transformedCurrentPlaceReviews.allIds = allIds;

        return transformedCurrentPlaceReviews;
    },

    normalizeReviewUsers(reviews) {
        let allUserIds = [];
        let users = [];
        for (let key in reviews.byId) {
            if (!reviews.byId.hasOwnProperty(key)) continue;
            let userId = reviews.byId[key].user.id;
            if (!allUserIds.includes(userId)) {
                users.push(reviews.byId[key].user);
                allUserIds.push(userId);
            }
        }

        let normalizeUsers = normalizerService.normalize({data: users}, {
            first_name: '',
            last_name: '',
            avatar_url: ''
        });
        normalizeUsers.allIds = [];
        for (let k in normalizeUsers.byId){
            normalizeUsers.allIds.push(parseInt(k));
        }

        return normalizeUsers;
    },

    getReviewSchema: () => {
        return {
            created_at: '',
            description: '',
            dislikes: 0,
            like: 'NONE',
            likes: 0,
            user_id: 0,
            photos: []
        };
    },
};

export default normalizerService;