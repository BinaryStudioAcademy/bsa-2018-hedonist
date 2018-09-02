import _ from 'lodash';

function sortComparator(a, b){
    if(a > b){
        return 1;
    }else if(a < b){
        return -1;
    }else{
        return 0;
    }
}

export default {
    getPreloadedRecentPlaceReviewsIds: state => placeId => {
        const reviews = state.reviews;
        return _.get(reviews, ['byPlaces', placeId, 'reviews'], [])
            .sort((a, b) => sortComparator(
                new Date(reviews.byId[b].created_at),
                new Date(reviews.byId[a].created_at)
            ))
            .slice(0, state.reviews.reviewsPerPage);
    },

    getPreloadedPopularPlaceReviewsIds: state => placeId => {
        const reviews = state.reviews;
        return _.get(reviews, ['byPlaces', placeId, 'reviews'], [])
            .sort((a, b) => {
                let result = reviews.byId[b].likes - reviews.byId[a].likes;
                if(result === 0){
                    sortComparator(
                        new Date(reviews.byId[b].created_at),
                        new Date(reviews.byId[a].created_at)
                    )
                }
            })
            .slice(0, state.reviews.reviewsPerPage);
    },

    getPlaceReviewsByIds: state => (placeId, ids) => {
        return ids.map(id => {
            const review = state.reviews.byId[id];

            return {
                ...review,
                user: state.users.byId[review.user_id]
            }
        });
    },

    getTotalReviewCount: state => placeId => {
        return _.get(state.reviews, ['byPlaces', placeId, 'totalCount'], 0);
    },
};
