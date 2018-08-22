export default {
    getMyTastesIds: state => {
        if (state.myTastes.byId !== undefined) {
            return Object.keys(state.myTastes.byId);
        } else {
            return [];
        }
    }
};
