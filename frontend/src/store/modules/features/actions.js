import httpService from '@/services/common/httpService';
import normalizerService from '@/services/common/normalizerService';

export default {
    fetchAllFeatures: (context) => {
        return new Promise((resolve, reject) => {
            httpService.get('/places/features')
                .then((result) => {
                    let normalizeData = normalizerService.normalize(result.data);
                    console.log('Norm: ' + JSON.stringify(normalizerService.normalize(result.data)) + ' Result: ' + JSON.stringify(result.data));
                    context.commit('SET_ALL_FEATURES', normalizeData);
                    resolve(result);
                })
                .catch((error) => {
                    reject(error);
                });
        })
    }

    // getAllFeatures: () => {
    //     return new Promise((resolve, reject) => {
    //         httpService.get('places/features')
    //             .then((result) => {
    //                 resolve(result.data.data);
    //             })
    //             .catch((error) => {
    //                 reject(error);
    //             });
    //     });
    // }
};