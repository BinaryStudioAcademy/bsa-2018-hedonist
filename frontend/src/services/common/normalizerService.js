export const normalizerService = {

    normalize(response, shape = {}) {
        let result = {};

        if (Array.isArray(response.data)) {
            result = this.normalizeArray(response.data, shape);
        } else {
            result = this.normalizeObject(response.data, shape);
        }

        return {
            byId: result
        };
    },

    normalizeArray(data, shape){
        return data.reduce((normalizedObject, item) => {
            return Object.assign(normalizedObject, this.normalizeObject(item,shape));
        }, {});
    },

    normalizeObject(data, shape){
        if('id' in data){
            return {
                [data.id]: Object.assign({}, shape, data)
            };
        } else{
            return {};
        }
    }
};

export default normalizerService;