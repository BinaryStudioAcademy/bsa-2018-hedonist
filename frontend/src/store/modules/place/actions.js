import httpService from '../../../services/common/httpService';

export default {
    featchPlaces: (context) => {
        return new Promise((resolve, reject) => {
            httpService.get('/places')
                .then(function (res) {
                    if (res.status === 400){
                        resolve(res.data);
                    } else {
                        context.commit('SET_PLACES', res);
                        resolve(res);
                    }
                }).catch(function (err) {
                    reject(err);
                });
        });
    },
}