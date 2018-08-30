import httpService from '@/services/common/httpService';

export default {
    checkIn: (context, data) => {
        return httpService.post('/users/me/checkins', data)
            .then(response => {
                return Promise.resolve(response);
            })
            .catch(error => {
                return Promise.reject(error);
            });
    },

    loadCheckInPlaces: (context) => {
        return new Promise((resolve, reject) => {
            httpService.get('/users/me/checkins')
                .then(function ({ data }) {
                    let checkIns = transformCheckins(data.data);
                    let allCheckinIds = data.data.reduce(
                        (ids, checkin) => {
                            ids.push(checkin.id);
                            return ids;
                        },
                        []
                    );
                    let checkInPlaces = transformPlaces(data.data);
                    context.commit('SET_CHECK_INS', {
                        items: checkIns,
                        ids: allCheckinIds
                    });
                    context.commit('SET_PLACES', checkInPlaces);
                    context.commit('SET_LOADING_STATE' , false);
                    resolve({checkIns, checkInPlaces});
                })
                .catch(function (err) {
                    reject(err);
                });
        });
    },

    setLoadingState: ({commit} ,loadState) => {
        commit('SET_LOADING_STATE' , loadState);
    },

    setCurrentMapCenter: ({ commit }, currentCenter) => {
        commit('SET_CURRENT_MAP_CENTER', currentCenter);
    },

    mapInitialization: ({ commit }) => {
        commit('MAP_INIT', true);
    }
};

const transformCheckins = (data) => {
    let transformedObj = {};

    data.forEach((checkIn) => {
        transformedObj[checkIn.id] = {
            id: checkIn.id,
            createdAt: checkIn.createdAt,
            placeId: checkIn.place.id
        };
    });

    return transformedObj;
};

const transformPlaces = (data) => {
    let transformedObj = {};

    data.forEach((checkIn) => {
        transformedObj[checkIn.place.id] = {
            id: checkIn.place.id,
            latitude: checkIn.place.latitude,
            longitude: checkIn.place.longitude,
            zip: checkIn.place.zip,
            address: checkIn.place.address,
            city: {
                id: checkIn.place.city.id,
                name: checkIn.place.city.name
            },
            category: {
                id: checkIn.place.category.id,
                name: checkIn.place.category.name
            },
            createdAt: checkIn.place.createdAt,
            localization: checkIn.place.localization.map((localization) => {
                return {
                    id: localization.id,
                    name: localization.name,
                };
            }),
            photos: checkIn.place.photos.map((photo) => {
                return {
                    id: photo.id,
                    description: photo.description,
                    img_url: photo['img_url'],
                    creator_id: photo['creator_id'],
                };
            }),
            rating: checkIn.place.rating
        };
    });

    return transformedObj;
};
