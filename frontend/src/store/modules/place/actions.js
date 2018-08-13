import httpService from '../../../services/common/httpService';

export default {
    featchPlaces: (context) => {
        return new Promise((resolve, reject) => {
            httpService.get('/places')
                .then(function (res) {
                    if (res.status === 200){
                        context.commit('SET_PLACES', res.data);
                        resolve(res.data);
                    } else {
                        resolve(res);
                    }
                }).catch(function (err) {
                    reject(err);
                });
        });
    },
}