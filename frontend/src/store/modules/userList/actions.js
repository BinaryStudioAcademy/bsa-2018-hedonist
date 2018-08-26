import httpService from '../../../services/common/httpService';
import normalizerService from '../../../services/common/normalizerService';

export default {
    getListsByUser: (context, userId) => {
        return new Promise((resolve, reject) => {
            httpService.get(`/users/${userId}/lists`)
                .then( (response) => {
                    const userLists = response.data.data;
                    context.commit('SET_USER_LISTS', userLists);
                    let normalizedUserLists = normalizerService.normalize(response.data);
                    normalizedUserLists.allIds = [];

                    let normalizedPlaces = {
                        byId: {},
                        allIds: []
                    };

                    let normalizedCities = {
                        byId: {},
                        allIds: []
                    };

                    let normalizedCategories = {
                        byId: {},
                        allIds: []
                    };

                    for (let userList in normalizedUserLists.byId){
                        let userListId = parseInt(userList);
                        normalizedUserLists.allIds.push(userListId);

                        let normalizedPlacesOfOneList = normalizerService.normalize({
                            data : normalizedUserLists.byId[userListId].places
                        });

                        normalizedPlacesOfOneList.allIds = [];
                        for (let place in normalizedPlacesOfOneList.byId){
                            let placeId = parseInt(place);
                            normalizedPlacesOfOneList.allIds.push(placeId);
                            normalizedPlaces.byId[placeId] = normalizedPlacesOfOneList.byId[placeId];
                        }
                        normalizedUserLists.byId[userListId].places = normalizedPlacesOfOneList.allIds;
                    }

                    for (let place in normalizedPlaces.byId){
                        let placeId = parseInt(place);
                        normalizedPlaces.allIds.push(placeId);

                        let normalizedCityOfOnePlace = normalizerService.normalize({
                            data : normalizedPlaces.byId[placeId].city
                        });
                        for (let city in normalizedCityOfOnePlace.byId){
                            let cityId = parseInt(city);
                            normalizedCities.byId[cityId] = normalizedCityOfOnePlace.byId[cityId];
                        }
                        delete normalizedPlaces.byId[placeId].city;

                        let normalizedCategoryOfOnePlace = normalizerService.normalize({
                            data : normalizedPlaces.byId[placeId].category
                        });
                        for (let category in normalizedCategoryOfOnePlace.byId){
                            let categoryId = parseInt(category);
                            normalizedCategories.byId[categoryId] = normalizedCategoryOfOnePlace.byId[categoryId];
                        }
                        delete normalizedPlaces.byId[placeId].category;
                    }

                    for (let city in normalizedCities.byId){
                        normalizedCities.allIds.push(parseInt(city));
                    }

                    for (let category in normalizedCategories.byId){
                        normalizedCategories.allIds.push(parseInt(category));
                    }

                    context.commit('SET_NORMALIZED_USER_LISTS', normalizedUserLists);
                    context.commit('SET_NORMALIZED_PLACES', normalizedPlaces);
                    context.commit('SET_NORMALIZED_CITIES', normalizedCities);
                    context.commit('SET_NORMALIZED_CATEGORIES', normalizedCategories);

                    resolve(userLists);
                })
                .catch( (error) => {
                    reject(error);
                });
        });
    },

    addPlaceToList: (context, payload) => {
        return new Promise((resolve, reject) => {
            httpService.post('/user-lists/' + payload.listId + '/attach-place', {
                id: payload.placeId
            })
                .then( (result) => {
                    context.dispatch('getListsByUser');
                    resolve(result);
                })
                .catch( (error) => {
                    reject(error);
                });
        });
    },


};