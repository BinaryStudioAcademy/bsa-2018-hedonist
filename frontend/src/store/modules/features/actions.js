import httpService from '@/services/common/httpService';

export default {
    fetchAllFeatures: (context) => {
        return new Promise((resolve, reject) => {
            httpService.get('/places/features')
                .then((result) => {
                    context.commit('SET_ALL_FEATURES', result.data.data);
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