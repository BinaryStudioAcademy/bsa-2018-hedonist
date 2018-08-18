export const normalizerService = {
    normalize(response, shape = {}){
        const { data } = response;

        const transformed = data.map(item => {
            return {
                [item.id]: Object.assign({}, shape, item)
            };
        });

        return {
            byId: transformed,
        };
    }
};

export default normalizerService;