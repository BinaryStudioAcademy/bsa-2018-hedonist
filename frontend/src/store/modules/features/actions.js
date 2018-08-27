import httpService from '@/services/common/httpService';

export default {
    getAllFeatures: () => {
        return new Promise((resolve, reject) => {
            httpService.get('places/features')
                .then((result) => {
                    resolve(result.data.data);
                })
                .catch((error) => {
                    reject(error);
                });
        });
    }
};