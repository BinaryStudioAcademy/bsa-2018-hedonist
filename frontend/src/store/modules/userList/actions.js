import httpService from '../../../services/common/httpService';
import normalizerService from '../../../services/common/normalizerService';

export default {
    getListsByUser: (context, userId) => {
        return new Promise((resolve, reject) => {
            httpService.get(`/users/${userId}/lists`)
                .then( (response) => {
                    let userLists = normalizerService.normalize(response.data);
                    userLists = normalizerService.updateAllIds(userLists);
                    let places = {};
                    let cities = {};
                    let categories = {};

                    for (let userList in userLists.byId){
                        let id = parseInt(userList);

                        let placesOfOneList = normalizerService.normalize({
                            data : userLists.byId[id].places
                        });

                        places = normalizerService.updateNormalizedData(
                            places,
                            placesOfOneList
                        );

                        userLists.byId[id].places =
                            normalizerService.updateAllIds(placesOfOneList).allIds;
                    }
                    places = normalizerService.updateAllIds(places);

                    for (let place in places.byId){
                        let id = parseInt(place);

                        cities = normalizerService.updateNormalizedData(
                            cities,
                            normalizerService.normalize({
                                data : places.byId[id].city
                            })
                        );
                        delete places.byId[id].city;

                        categories = normalizerService.updateNormalizedData(
                            categories,
                            normalizerService.normalize({
                                data : places.byId[id].category
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

    getListById: (context, placeId) => {
        return httpService.get(`/user-lists/${placeId}`)
            .then((result) => {
                console.dir(result.data.data);
            });
    }
};