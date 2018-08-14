import httpService from '../../../services/common/httpService';

export default {
    checkIn: (context, data) => {
        return new Promise((resolve, reject) => {
            httpService.post('/users/me/checkins', data)
                .then(function(res) {
                    if (res.status === 400){
                        resolve(res.data);
                    } else {
                        resolve(res);
                    }
                })
                .catch(function(err) {
                    reject(err);
                });
        });
    },
    
    setPlaceRating: (context, data) => {
        return new Promise((resolve, reject) => {
            httpService.post('/places/rating', data)
                .then(function(res) {
                    if (res.status === 400){
                        resolve(res.data);
                    } else {
                        resolve(res);
                    }
                })
                .catch(function(err) {
                    reject(err);
                });
        });
    }
};
