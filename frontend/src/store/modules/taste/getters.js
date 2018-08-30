export default {
    getMyTastesIds: state => {
        if (state.myTastes.byId !== undefined) {
            return Object.keys(state.myTastes.byId);
        } else {
            return [];
        }
    },
    getAllTastesIds: state => {
        if (state.allTastes.byId !== undefined) {
            return Object.keys(state.allTastes.byId);
        } else {
            return [];
        }
    }
};
