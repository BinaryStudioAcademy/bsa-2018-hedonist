import httpService from '../../../services/common/httpService';
import normalizerService from '../../../services/common/normalizerService';

export default {
    getListsByUser: (context, userId) => {
        return new Promise((resolve, reject) => {
            httpService.get(`/users/${userId}/lists`)
                .then((response) => {
                    let userLists = normalizerService.normalize(response.data);
                    userLists = normalizerService.updateAllIds(userLists);
                    let places = {};
                    let cities = {};
                    let categories = {};

                    for (let userList in userLists.byId) {
                        let id = parseInt(userList);

                        let placesOfOneList = normalizerService.normalize({
                            data: userLists.byId[id].places
                        });

                        places = normalizerService.updateNormalizedData(
                            places,
                            placesOfOneList
                        );

                        userLists.byId[id].places =
                            normalizerService.updateAllIds(placesOfOneList).allIds;
                    }
                    places = normalizerService.updateAllIds(places);

                    for (let place in places.byId) {
                        let id = parseInt(place);

                        cities = normalizerService.updateNormalizedData(
                            cities,
                            normalizerService.normalize({
                                data: places.byId[id].city
                            })
                        );
                        delete places.byId[id].city;

                        categories = normalizerService.updateNormalizedData(
                            categories,
                            normalizerService.normalize({
                                data: places.byId[id].category
                            })
                        );
                        delete places.byId[id].category;
                    }
                    cities = normalizerService.updateAllIds(cities);
                    categories = normalizerService.updateAllIds(categories);

                    context.commit('SET_USER_LISTS', userLists);
                    context.commit('SET_PLACES', places);
                    context.commit('SET_CITIES', cities);
                    context.commit('SET_CATEGORIES', categories);

                    resolve();
                })
                .catch((error) => {
                    reject(error);
                });
        });
    },

    addPlaceToList: (context, payload) => {
        return new Promise((resolve, reject) => {
            httpService.post('/user-lists/' + payload.listId + '/attach-place', {
                id: payload.placeId
            })
                .then((result) => {
                    context.dispatch('getListsByUser',payload.userId);
                    resolve(result);
                })
                .catch((error) => {
                    reject(error);
                });
        });
    },

    getListById: (context, placeId) => {
        context.commit('SET_LOADING_STATE', true);
        return httpService.get(`/user-lists/${placeId}`)
            .then((response) => {
                const places = {byId: {}, allIds: []};
                const allLists = {byId: {}, allIds: []};
                const photos = {byId: {}, allIds: []};
                const cities = {byId: {}, allIds: []};
                const categories = {byId: {}, allIds: []};
                const reviews = {byId: {}, allIds: []};
                const result = response.data.data;
                const list = Object.assign({}, result);
                list.places = result.places.map((item) => {
                    const currentPlace = Object.assign({}, item);
                    cities.byId[item.city.id] = item.city;
                    currentPlace.city = item.city.id;
                    categories.byId[item.category.id] = item.category;
                    currentPlace.category = item.category.id;
                    if (item.review) {
                        reviews.byId[item.review.id] = item.review;
                        currentPlace.review = item.review.id;
                    }
                    currentPlace.photos = item.photos.map(item => {
                        photos.byId[item.id] = item;
                        return item.id;
                    });
                    places.byId[item.id] = currentPlace;

                    return item.id;
                });
                allLists.byId[list.id] = list;
                allLists.allIds.push(list.id);

                context.commit('SET_PLACES', normalizerService.updateAllIds(places));
                context.commit('SET_CITIES', normalizerService.updateAllIds(cities));
                context.commit('SET_CATEGORIES', normalizerService.updateAllIds(categories));
                context.commit('SET_REVIEWS', normalizerService.updateAllIds(reviews));
                context.commit('SET_USER_LISTS', allLists);
                context.commit('SET_PHOTOS',  normalizerService.updateAllIds(photos));

                context.commit('SET_LOADING_STATE', false);
            });
    },
    addUserList: (context, {userList, attachedPlaces}) => {
        const formData = new FormData();
        if(userList.image)
            formData.append('image', userList.image);
        formData.append('name', userList.name);
        _.forEach(attachedPlaces, function(place) {
            formData.append('attached_places[]', place.id);
        });

        return httpService.post('/user-lists/', formData)
            .then((result) => {
                return result.data.data;
            });
    },
    updateUserList: (context, {userList, attachedPlaces, id}) => {
        const formData = new FormData();
        formData.append('_method', 'PUT');
        if (userList.image !== null) {
            formData.append('image', userList.image);
        }

        if (userList.name !== null) {
            formData.append('name', userList.name);
        }

        _.forEach(attachedPlaces, function(place) {
            formData.append('attached_places[]', place.id);
        });

        return httpService.post(`/user-lists/${id}`, formData)
            .then((result) => {
                return result.data.data;
            });
    },
    deleteUserList: (context, id) => {
        return httpService.delete(`/user-lists/${id}`)
            .then((result) => {
                context.commit('REMOVE_USER_LIST', id);
                return result.data.data;
            });
    }
};