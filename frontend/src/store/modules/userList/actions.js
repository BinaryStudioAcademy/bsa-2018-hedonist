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
                    normalizedUserLists = normalizerService.updateAllIds(normalizedUserLists);
                    let normalizedPlaces = {};
                    let normalizedCities = {};
                    let normalizedCategories = {};

                    for (let userList in normalizedUserLists.byId){
                        let id = parseInt(userList);

                        let normalizedPlacesOfOneList = normalizerService.normalize({
                            data : normalizedUserLists.byId[id].places
                        });

                        normalizedPlaces = normalizerService.updateNormalizedData(
                            normalizedPlaces,
                            normalizedPlacesOfOneList
                        );

                        normalizedUserLists.byId[id].places =
                            normalizerService.updateAllIds(normalizedPlacesOfOneList).allIds;
                    }
                    normalizedPlaces = normalizerService.updateAllIds(normalizedPlaces);

                    for (let place in normalizedPlaces.byId){
                        let id = parseInt(place);

                        normalizedCities = normalizerService.updateNormalizedData(
                            normalizedCities,
                            normalizerService.normalize({
                                data : normalizedPlaces.byId[id].city
                            })
                        );
                        delete normalizedPlaces.byId[id].city;

                        normalizedCategories = normalizerService.updateNormalizedData(
                            normalizedCategories,
                            normalizerService.normalize({
                                data : normalizedPlaces.byId[id].category
                            })
                        );
                        delete normalizedPlaces.byId[id].category;
                    }
                    normalizedCities = normalizerService.updateAllIds(normalizedCities);
                    normalizedCategories = normalizerService.updateAllIds(normalizedCategories);

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
    }
};