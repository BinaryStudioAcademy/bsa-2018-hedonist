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
    },

    updateNormalizedData(targetNormalized, sourceNormalized){
        if (targetNormalized.byId === undefined)
            targetNormalized.byId = {};
        for (let el in sourceNormalized.byId){
            let elId = parseInt(el);
            targetNormalized.byId[elId] = sourceNormalized.byId[elId];
        }
        return targetNormalized;
    },

    updateAllIds(targetNormalized){
        if (targetNormalized.allIds === undefined)
            targetNormalized.allIds = [];
        for (let el in targetNormalized.byId){
            targetNormalized.allIds.push(parseInt(el));
        }
        return targetNormalized;
    }
};

export default normalizerService;