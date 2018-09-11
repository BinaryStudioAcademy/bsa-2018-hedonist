export default {
    getFilteredByName: state => name => {
        return state.places.filter(
            place => place.localization[0].name.toLowerCase().indexOf(name.toLowerCase()) > -1
        );
    },

    getById: state => id => {
        return new Promise(resolve => {
            setTimeout(() => {
                resolve(state.places.find(function (place) {
                    return place.id === parseInt(id);
                }));
            }, 500);
        });
    },

    getReviewsById: state => user_id => {
        return state.places
            .filter(
                place => place.review.user.id === user_id
            )
            .slice(0,10);
    },

    getUserReviewsAll: state => user_id => {
        return state.places
            .filter(
                place => place.review.user.id === user_id
            );
    },

    getLikedStatus: state => {
        return state.liked;
    },

    getLikes: state => {
        return state.currentPlace && state.currentPlace.likes;
    },

    getDislikes: state => {
        return state.currentPlace && state.currentPlace.dislikes;
    },

    getAllVisitorsButMe: (state, getters, rootState) => {
        let filtered = {
            byId: {},
            allIds: []
        };
        const myUserId = rootState.auth.currentUser.id;
        state.visitors.allIds.forEach(id=>{
            if(id == myUserId) return;
            filtered.byId[id] = state.visitors.byId[id];
            filtered.allIds.push(id);
        });
        return filtered;
    }
};
