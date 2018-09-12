import httpService from '../../../services/common/httpService';
import normalizerService from '../../../services/common/normalizerService';
import {FAVOURITE_LIST_NAME} from '@/services/userList/listNames';

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
                    context.commit('SET_FAVOURITE_EXIST', false);

                    for (let userList in userLists.byId) {
                        let id = parseInt(userList);

                        if (userLists.byId[id].is_default && userLists.byId[id].name === FAVOURITE_LIST_NAME) {
                            context.commit('SET_FAVOURITE_EXIST', true);
                        }
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

                    for (let placeId in places.byId) {
                        const place = places.byId[parseInt(placeId)];

                        cities = normalizerService.updateNormalizedData(
                            cities,
                            normalizerService.normalize({
                                data: place.city
                            })
                        );
                        place.city = place.city.id;

                        categories = normalizerService.updateNormalizedData(
                            categories,
                            normalizerService.normalize({
                                data: place.category
                            })
                        );
                        place.category = place.category.id;
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
                    context.dispatch('getListsByUser', payload.userId);
                    resolve(result);
                })
                .catch((error) => {
                    reject(error);
                });
        });
    },
    removePlaceFromList: (context, payload) => {
        return new Promise((resolve, reject) => {
            httpService.post('/user-lists/' + payload.listId + '/detach-place', {
                placeId: payload.placeId
            })
                .then((result) => {
                    context.commit('REMOVE_PLACE_FROM_LIST', {
                        placeId: payload.placeId,
                        listId: payload.listId
                    });
                    resolve(result);
                })
                .catch((error) => {
                    reject(error);
                });
        });
    },

    addPlaceToFavouriteList: (context, payload) => {
        return new Promise((resolve, reject) => {
            httpService.post('/user-lists/favourite', {
                id: payload.placeId
            })
                .then((result) => {
                    context.dispatch('getListsByUser', payload.userId);
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

                context.commit('UPDATE_PLACES', normalizerService.updateAllIds(places));
                context.commit('UPDATE_CITIES', normalizerService.updateAllIds(cities));
                context.commit('UPDATE_CATEGORIES', normalizerService.updateAllIds(categories));
                context.commit('UPDATE_REVIEWS', normalizerService.updateAllIds(reviews));
                context.commit('UPDATE_USER_LISTS', allLists);
                context.commit('UPDATE_PHOTOS', normalizerService.updateAllIds(photos));

                context.commit('SET_LOADING_STATE', false);
            });
    },
    addUserList: ({commit}, {userList, attachedPlaces}) => {
        const formData = new FormData();
        if (userList.image) {
            formData.append('image', userList.image);
        }
        const {normCities, normCategories, normPlaces} = normalizePlaceData(attachedPlaces);
        formData.append('name', userList.name);
        _.forEach(attachedPlaces, function (place) {
            formData.append('attached_places[]', place.id);
        });

        return httpService.post('/user-lists/', formData)
            .then(({data}) => {
                let userList = data.data;
                userList.places = [];
                commit('ADD_NEW_LIST', userList);
                commit('UPDATE_PLACES', normPlaces);
                commit('UPDATE_CITIES', normCities);
                commit('UPDATE_CATEGORIES', normCategories);
                return userList;
            });
    },
    updateUserList: ({commit}, {userList, attachedPlaces, id}) => {
        const formData = new FormData();
        const {normCities, normCategories, normPlaces} = normalizePlaceData(attachedPlaces);
        formData.append('_method', 'PUT');
        if (userList.image !== null) {
            formData.append('image', userList.image);

        }
        if (userList.name !== null) {
            formData.append('name', userList.name);
        }

        _.forEach(attachedPlaces, function (place) {
            formData.append('attached_places[]', place.id);
        });
        return httpService.post(`/user-lists/${id}`, formData)
            .then(({data}) => {
                const userList = data.data;
                commit('UPDATE_LIST', {userList, placeIds: normPlaces.allIds});
                commit('UPDATE_PLACES', normPlaces);
                commit('UPDATE_CITIES', normCities);
                commit('UPDATE_CATEGORIES', normCategories);
                return userList;
            });
    },
    deleteUserList: (context, id) => {
        return httpService.delete(`/user-lists/${id}`)
            .then((result) => {
                context.commit('REMOVE_USER_LIST', id);
                return result.data.data;
            });
    },
    deleteUserListImg: (context, id) => {
        return new Promise((resolve, reject) => {
            httpService.delete(`/user-lists/${id}/image`)
                .then((result) => { resolve(result); })
                .catch((error) => { reject(error); });
        });
    }
};

const normalizePlaceData = (unnormalizedPlaces) => {
    let cities = {byId: {}, allIds: []};
    let categories = {byId: {}, allIds: []};
    let places = {byId: {}, allIds: []};
    _.forEach(unnormalizedPlaces, function (unnormalizedPlace) {
        let place = Object.assign({}, unnormalizedPlace);
        let normCity = normalizerService.normalize({data: place.city});
        let normCategory = normalizerService.normalize({data: place.category});
        Object.assign(place, {city: place.city.id});
        Object.assign(place, {category: place.category.id});
        let normPlace = normalizerService.normalize({data: place});

        cities = normalizerService.updateNormalizedData(normCity, cities);
        cities = normalizerService.updateAllIds(normCity, cities);
        categories = normalizerService.updateNormalizedData(normCategory, categories);
        categories = normalizerService.updateAllIds(normCategory, categories);
        places = normalizerService.updateNormalizedData(normPlace, places);
        places = normalizerService.updateAllIds(normPlace, places);
    });

    return {
        normCities: cities,
        normCategories: categories,
        normPlaces: places
    };
};