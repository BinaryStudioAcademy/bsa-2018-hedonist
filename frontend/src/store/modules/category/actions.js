import httpService from '@/services/common/httpService';
import normalizerService from '@/services/common/normalizerService';

export default {
    fetchAllCategories: (context) => {
        return new Promise((resolve, reject) => {
            httpService.get('/places/categories')
                .then((result) => {
                    let normalizeData = normalizerService.normalize(result.data);
                    context.commit('SET_ALL_CATEGORIES', normalizeData.byId);
                    resolve(result);
                })
                .catch((error) => {
                    reject(error);
                });
        })
    },

    fetchCategoryTags: (context, categoryId) => {
        return new Promise((resolve, reject) => {
            httpService.get(`/places/categories/${categoryId}/tags`)
                .then((result) => {
                    let normalizeData = normalizerService.normalize(result.data);
                    context.commit('SET_CATEGORY_TAGS', normalizeData);
                    resolve(result);
                })
                .catch((error) => {
                    reject(error);
                });
        })
    }
};