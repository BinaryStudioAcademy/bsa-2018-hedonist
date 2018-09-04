export default {
    SET_USER_LISTS: (state, userLists) => {
        state.userLists = userLists;
    },
    SET_PLACES: (state, places) => {
        state.places = places;
    },
    SET_CITIES: (state, cities) => {
        state.cities = cities;
    },
    SET_CATEGORIES: (state, categories) => {
        state.categories = categories;
    },
    SET_LOADING_STATE: (state,loadingState) => {
        state.isLoading = loadingState;
    },
    SET_REVIEWS: (state, reviews) => {
        state.reviews = reviews;
    },
    SET_PHOTOS: (state, photos) => {
        state.photos = photos;
    },
    REMOVE_USER_LIST: (state, id) => {
        state.userLists.byId = _.filter(state.userLists.byId, (list) => list.id !== id);
        state.userLists.allIds = _.filter(state.userLists.allIds, (listId) => listId !== id);
    },
    UPDATE_USER_LISTS: (state, userLists) => {
        _.forEach(userLists.allIds, function(id) {
            state.userLists.byId[id] = userLists.byId[id];
            if (!_.includes(state.userLists.allIds, id)) {
                state.userLists.allIds.push(id);
            }
        });
    },
    UPDATE_PLACES: (state, places) => {
        _.forEach(places.allIds, function(id) {
            state.places.byId[id] = places.byId[id];
            if (!_.includes(state.places.allIds, id)) {
                state.places.allIds.push(id);
            }
        });
    },
    UPDATE_CITIES: (state, cities) => {
        _.forEach(cities.allIds, function(id) {
            state.cities.byId[id] = cities.byId[id];
            if (!_.includes(state.cities.allIds, id)) {
                state.cities.allIds.push(id);
            }
        });
    },
    UPDATE_CATEGORIES: (state, categories) => {
        _.forEach(categories.allIds, function(id) {
            state.categories.byId[id] = categories.byId[id];
            if (!_.includes(state.categories.allIds, id)) {
                state.categories.allIds.push(id);
            }
        });
    },
    UPDATE_REVIEWS: (state, reviews) => {
        _.forEach(reviews.allIds, function(id) {
            state.reviews.byId[id] = reviews.byId[id];
            if (!_.includes(state.reviews.allIds, id)) {
                state.reviews.allIds.push(id);
            }
        });
    },
    UPDATE_PHOTOS: (state, photos) => {
        _.forEach(photos.allIds, function(id) {
            state.photos.byId[id] = photos.byId[id];
            if (!_.includes(state.photos.allIds, id)) {
                state.photos.allIds.push(id);
            }
        });
    },
    ADD_NEW_LIST: (state, userList) => {
        state.userLists.byId[userList.id] = userList;
        state.userLists.allIds.push(userList.id);
    },
    UPDATE_LIST: (state, { userList, placeIds }) => {
        state.userLists.byId[userList.id].name = userList.name;
        state.userLists.byId[userList.id]['img_url'] = userList['img_url'];
        state.userLists.byId[userList.id].places = placeIds;
    },
};
