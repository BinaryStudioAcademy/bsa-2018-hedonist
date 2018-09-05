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

    getLikedStatus: state => {
        return state.liked;
    },

    getLikes: state => {
        return state.currentPlace && state.currentPlace.likes;
    },

    getDislikes: state => {
        return state.currentPlace && state.currentPlace.dislikes;
    }
};
