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
                    let checkInPlaces = transformPlaces(data.data);
                    context.commit('SET_CHECK_INS', checkIns);
                    context.commit('SET_PLACES', checkInPlaces);
                    resolve({checkIns, checkInPlaces});
                })
                .catch(function (err) {
                    reject(err);
                });
        });
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
            city: checkIn.place.city,
            category: checkIn.place.category,
            createdAt: checkIn.place.createdAt,
            name: checkIn.place.name,
            rating: checkIn.place.rating
        };
    });

    return transformedObj;
};